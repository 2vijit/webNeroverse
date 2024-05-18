<?php

namespace App\Http\Controllers;

use App\Mail\ApprovePayment;
use App\Mail\ReservationMail;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Package;
use App\Models\ReservedRoom;
use App\Models\Setting;
use App\Models\User;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use niklasravnsborg\LaravelPdf\Facades\Pdf as FacadesPdf;
use niklasravnsborg\LaravelPdf\Pdf as LaravelPdfPdf;

class ReservationControlller extends Controller
{
    public function index()
    {

        return view('reservation.index');
    }

    public function list()
    {
        if (Auth::user()->type == 'admin') {
            // $reservation = Reservation::all();
            $reservation = Reservation::with(['reservedRooms.room', 'user'])->get()->sortByDesc('created_at');
        } else if (Auth::user()->type == 'agent') {
            $reservation = Reservation::query()->where('added_by', auth()->user()->id)->get()->sortByDesc('created_at');
        }
        return datatables()->of($reservation)

            // ->addColumn('status', function (Reservation $status) 
            // {
            //     if ($status->status == 'pending') 
            //     {                   
            //         return "<button id='approveButton' class='btn btn-warning' data-reservation-id='$status->id'>Pending</button>";
            //     } 
            //     elseif ($status->status == 'approved') 
            //     {
            //         return "<label class='btn btn-success'>Approved</label>";
            //     }
            // })

            ->addColumn('status', function ($reservation) {
                $btn = '';
                if ($reservation->status == 'approved') {
                    $btn = $btn . '<a title="edit" class="btn btn-success" data-panel-id="' . $reservation->id . '" onclick="changeStatus(this)">Approved</a>';
                } else {
                    $btn = $btn . '<a title="edit" class="btn btn-warning" data-panel-id="' . $reservation->id . '" onclick="changeStatus(this)">Pending</a>';
                }
                return $btn;
            })
            ->addColumn('room_names', function ($reservation) {
                $roomNames = $reservation->reservedRooms->pluck('room.name')->toArray();
                return implode(', ', $roomNames);
            })



            ->addColumn('user_name', function ($reservation) {
                return $reservation->user ? $reservation->user->name : 'N/A';
            })

            ->rawColumns(['status'])
            ->setRowAttr([
                'align' => 'center',
            ])->make(true);
    }



    public function create()
    {
        $room = Room::query()->get();
        $package = Package::query()->get();
        return view('reservation.create', compact('room', 'package'));
    }


    public function store(Request $request)
    {

        $validated = $this->validate(
            $request,
            [
                'name' => 'required',
                'phone' => ['required', 'string', 'max:11'],
                'email' => 'required',
                'address' => 'required',
                'check_in' => 'required',
                'check_out' => 'required',
                'no_of_adults' => 'required',
                'no_of_kids' => 'nullable',
                'room_id' => 'required|array',
                'room_id.*' => 'exists:room,id',
                'extra_charge' => 'nullable',
                'extra_note' => 'nullable',
            ]
        );

        $checkIn = new \DateTime($validated['check_in']);
        $checkOut = new \DateTime($validated['check_out']);
        $totalNight = $checkIn->diff($checkOut)->days;

        $checkInTime = config('constant.CHECK_IN_TIME');
        $checkOutTime = config('constant.CHECK_OUT_TIME');

        $checkInDateTime = Carbon::parse($request->check_in . ' ' . $checkInTime);
        $checkOutDateTime = Carbon::parse($request->check_out . ' ' . $checkOutTime);

        $roomId = $validated['room_id'];

        $room = Room::where('id', $roomId)->first();

        $user = User::where('phone', $validated['phone'])->first();

        if (!$user) {
            $customerCount = User::where('type', 'customer')->count();
            $customerCount++;
            $customerId = 'C' . str_pad($customerCount, 2, '0', STR_PAD_LEFT);
            $user = User::query()->create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'email' => $validated['email'],
                'type' => 'customer',
                'status' => 'active',
                'password' => Hash::make('123456789'),
                'customer_id' => $customerId,
            ]);

            $customer = Customer::query()->create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'email' => $validated['email'],
                'fkUserId' => $user->id,
                'customer_id' => $customerId,
            ]);
        }
        $totalPrice = 0;
        $regularPrice = 0;
        foreach ($request->room_id as $reserveItem) {
            $room = Room::find($reserveItem);
            if ($room) {
                $roomPrice = $room->discount_price !== null && $room->discount_price != 0 ? $room->discount_price : $room->price;
                $roomRegularPrice = $room->price;
                $regularPrice += $roomRegularPrice * $totalNight;
                $totalPrice += $roomPrice * $totalNight;
            }
        }

        $extraCharge = $request->extra_charge;
        $grandTotal = $totalPrice + ($request->extra_charge);
        $due = $grandTotal;
        $discount = $regularPrice - $totalPrice;
        $conflictingReservation = Reservation::with('reservedRooms')
            ->whereHas('reservedRooms', function ($query) use ($roomId, $checkInDateTime, $checkOutDateTime) {
                $query->where('room_id', $roomId)
                    ->where(function ($query) use ($checkInDateTime, $checkOutDateTime) {
                        $query->whereBetween('check_in', [$checkInDateTime, $checkOutDateTime])
                            ->orWhereBetween('check_out', [$checkInDateTime, $checkOutDateTime])
                            ->orWhere(function ($query) use ($checkInDateTime, $checkOutDateTime) {
                                $query->where('check_in', '<=', $checkInDateTime)
                                    ->where('check_out', '>=', $checkOutDateTime);
                            });
                    });
            })
            ->first();  


        $reservationCount = Reservation::count();
        $reservationCount++;
        $reservationId = 'R' . str_pad($reservationCount, 2, '0', STR_PAD_LEFT);


        if (!$conflictingReservation) {
            $reservation = Reservation::query()->create([
                'check_in' => $checkInDateTime,
                'check_out' => $checkOutDateTime,
                'no_of_adults' => $validated['no_of_adults'],
                'no_of_kids' => $validated['no_of_kids'],
                'added_by' => auth()->user()->id,
                'fkUserId' => $user->id,
                'reservation_id' => $reservationId,
                'total_price' => $totalPrice,
                'grand_total' => $grandTotal,
                'due' => $due,
                'totalPaid' => 0,
                'payment_status' => 'pending',
                'status' => 'pending',
                'extra_note' => $validated['extra_note'],
                'extra_charge' => $extraCharge,
                'discount_price' => $discount,
                'sub_total' => $regularPrice,
            ]);

            foreach ($request->room_id as $key => $reserveItem) {
                $reserveRoom = new ReservedRoom();
                $reserveRoom->fkReserveId = $reservation->id;
                $reserveRoom->room_id = $reserveItem;
                $reserveRoom->check_in = $reservation->check_in;
                $reserveRoom->check_out = $reservation->check_out;
                $reserveRoom->save();
            }

            // $user = User::query()->create([
            //     'name' => $validated['name'],
            //     'phone' => $validated['phone'],
            //     'address' => $validated['address'],
            //     'email' => $validated['email'],

            //     'fkBookingId' => $reservation->id,
            // ]);          

            Session::flash('success', 'Reservation Created Successfully!');
            return redirect()->route('reservation.show');
        } else {
            Session::flash('danger', 'Room has already booked!');
            return redirect()->route('reservation.create');
        }
    }

    public function edit($id)
    {
        $reservation = Reservation::with('user')->where('id', $id)->first();
        // dd($reservation);
        $reserveRoom = ReservedRoom::query()->where('fkReserveId', $id)->get();
        // $customer=Customer::where('fkUserId',$reservation->id)->first();
        $room = Room::query()->get();
        $package = Package::query()->get();
        return view('reservation.edit', compact('reservation', 'room', 'package', 'reserveRoom'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $this->validate($request, [
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date',
            'room_id' => 'nullable',
            'no_of_adults' => 'nullable',
            'no_of_kids' => 'nullable',
            'name' => 'nullable',
            'email' => 'email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'extra_note' => 'nullable',
            'extra_charge' => 'nullable'
        ]);

        $checkIn = new \DateTime($validated['check_in']);
        $checkOut = new \DateTime($validated['check_out']);
        $totalNight = $checkIn->diff($checkOut)->days;

        $checkInTime = config('constant.CHECK_IN_TIME');
        $checkOutTime = config('constant.CHECK_OUT_TIME');

        $checkInDateTime = Carbon::parse($request->check_in . ' ' . $checkInTime);
        $checkOutDateTime = Carbon::parse($request->check_out . ' ' . $checkOutTime);

        $roomId = $validated['room_id'];
        $reservation = Reservation::query()->where('id', $id)->first();
        $totalPrice = 0;
        $regularPrice = 0;
        foreach ($request->room_id as $reserveItem) {
            $room = Room::find($reserveItem);

            if ($room) {
                $roomPrice = $room->discount_price !== null && $room->discount_price != 0 ? $room->discount_price : $room->price;
                $roomRegularPrice = $room->price;
                $regularPrice += $roomRegularPrice * $totalNight;
                $totalPrice += $roomPrice * $totalNight;
            }
        }

        $grandTotal = $totalPrice + ($request->extra_charge);
        $due = $grandTotal;



        // Check room availability for the new date range
        $conflictingReservation = Reservation::with('reservedRooms')
            ->whereHas('reservedRooms', function ($query) use ($roomId, $checkInDateTime, $checkOutDateTime) {
                $query->where('room_id', $roomId)
                    ->where(function ($query) use ($checkInDateTime, $checkOutDateTime) {
                        $query->whereBetween('check_in', [$checkInDateTime, $checkOutDateTime])
                            ->orWhereBetween('check_out', [$checkInDateTime, $checkOutDateTime])
                            ->orWhere(function ($query) use ($checkInDateTime, $checkOutDateTime) {
                                $query->where('check_in', '<=', $checkInDateTime)
                                    ->where('check_out', '>=', $checkOutDateTime);
                            });
                    });
            })
            ->where('id', '<>', $id) // Exclude the current reservation from the check
            ->first();

        if (!$conflictingReservation) {
            // Update reservation details
            $reservation->update([
                'check_in' => $checkInDateTime,
                'check_out' => $checkOutDateTime,
                'no_of_adults' => $validated['no_of_adults'],
                'no_of_kids' => $validated['no_of_kids'],
                'added_by' => auth()->user()->id,
                'status' => $request->status,
                'total_price' => $totalPrice,
                'grand_total' => $grandTotal,
                'sub_total' => $regularPrice,
                'due' => $due,
                'totalPaid' => 0,
                'payment_status' => $request->payment_status,
                'extra_note' => $validated['extra_note'],
                'extra_charge' => $validated['extra_charge'],
            ]);


            if ($request->room_id) {
                $existingRooms = ReservedRoom::where('fkReserveId', $reservation->id)->pluck('room_id')->toArray();
                $roomsToDelete = array_diff($existingRooms, $request->room_id);
                ReservedRoom::where('fkReserveId', $reservation->id)
                    ->whereIn('room_id', $roomsToDelete)
                    ->delete();

                foreach ($request->room_id as $reserveRoom) {
                    ReservedRoom::updateOrCreate(
                        ['fkReserveId' => $reservation->id, 'room_id' => $reserveRoom],
                        ['check_in' => $reservation->check_in, 'check_out' => $reservation->check_out]
                    );
                }
            } else {

                ReservedRoom::where('fkReserveId', $reservation->id)->delete();
            }


            if ($request->c_id) {
                $user = User::query()->where('id', $request->c_id)->first();
                if (!empty($user)) {
                    $user->update([
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'],
                        'address' => $validated['address'],
                    ]);
                }

                $customer = Customer::query()->where('fkUserId', $request->c_id)->first();

                if (!empty($customer)) {
                    $customer->update([
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'],
                        'address' => $validated['address'],
                    ]);
                }
            }
            Session::flash('success', 'Reservation Updated Successfully');
            return redirect()->route('reservation.show');
        } else {
            Session::flash('danger', 'Room has already been booked for the selected date range!');
            return redirect()->back(); // Redirect back to the edit page
        }
    }


    public function delete(Request $request)
    {
        $reservation = Reservation::find($request->id);

        if (!$reservation) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $reservation->reservedRooms()->delete();
        $reservation->delete();
        return response()->json();
    }

    public function checkConflicts(Request $request)
    {

        $roomId = $request->input('room_id');
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');

        // Perform the conflict check logic here using the provided room ID, check-in, and check-out dates
        $conflict = $this->checkForConflicts($roomId, $checkIn, $checkOut);

        return response()->json(['conflict' => $conflict]);
    }


    private function checkForConflicts($roomId, $checkIn, $checkOut)
    {

        $conflictingReservation = Reservation::whereHas('reservedRooms', function ($query) use ($roomId) {
            $query->where('room_id', $roomId);
        })
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                    });
            })
            ->exists();

        return $conflictingReservation;
    }

    public function fullCalender()
    {
        $rooms = Room::all();
        $events = [];

        for ($month = 1; $month <= 12; $month++) {

            $startOfMonth = now()->setMonth($month)->startOfMonth();
            $endOfMonth = now()->setMonth($month)->endOfMonth();

            for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {

                foreach ($rooms as $room) {
                    $isBooked = ReservedRoom::where('room_id', $room->id)
                        ->where('check_in', '<=', $date)
                        ->where('check_out', '>=', $date)
                        ->exists();


                    $color = $isBooked ? '#FF0000' : '#4169E1';

                    $event = [
                        'title' => $room->name,
                        'start' => $date->format('Y-m-d'),
                        'color' => $color,
                    ];

                    $events[] = $event;
                }
            }
        }

        return view('reservation.calender', compact('events'));
    }

    // public function fullCalender()
    // {

    //     $startOfYear = now()->startOfYear();
    //     $endOfYear = now()->endOfYear();   
    //     $rooms = Room::all();   
    //     $events = [];   
    //     for ($month = 1; $month <= 12; $month++) {

    //         $startOfMonth = now()->setMonth($month)->startOfMonth();
    //         $endOfMonth = now()->setMonth($month)->endOfMonth();


    //         for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {

    //             foreach ($rooms as $room) {

    //                 $isBooked = ReservedRoom::where('room_id', $room->id)
    //                     ->where('check_in', '<=', $date)
    //                     ->where('check_out', '>=', $date)
    //                     ->exists();


    //                 $color = $isBooked ? '#FF5733' : '#000066';


    //                 $event = [
    //                     'title' => $room->name,
    //                     'start' => $date->format('Y-m-d'),
    //                     'color' => $color, 
    //                 ];

    //                 $events[] = $event;
    //             }
    //         }
    //     }


    //     return view('reservation.calender', compact('events', 'startOfYear', 'endOfYear'));
    // }



    public function statusUpdate(Request $request)
    {
        $reservation = Reservation::with('user')->find($request->id);
        if ($reservation) {
            $reservation->status = ($reservation->status == 'approved') ? 'pending' : 'approved';
            $user = User::find($reservation->fkUserId);

            try {
                if ($user && $user->email) {
                    $pdf = FacadesPdf::loadView('reservation.myPdf', ['reservation_info' => $reservation, 'user' => $user]);
                    $pdfPath =  public_path('invoices' . $reservation->reservation_id . '_invoice.pdf');
                    $pdf->save($pdfPath);
                    $emailData = [
                        'reservation' => $reservation,
                        'user' => $user,
                    ];

                    Mail::to($user->email)->send(new ReservationMail($emailData, $pdfPath));

                    if (file_exists($pdfPath)) {
                        unlink($pdfPath);
                    }
                }
            } catch (\Exception $exception) {
            }

            $reservation->save();
            return response()->json(['status' => $reservation->status]);
        }

        return response()->json(['error' => 'Reservation not found'], 404);
    }

    // public function print(Request $request)
    // {
    //     $data = Reservation::find($request->id);
    //     $dompdf = new Dompdf();
    //     $html = view('reservation.myPdf', compact('data'),[
    //         'mode'                 => 'utf-8',
    //         'format'               => 'A4-P',
    //         'default_font_size'    => '12',
    //         'default_font'         => 'FreeSerif',
    //         'margin_left'          => 5,
    //         'margin_right'         => 5,
    //         'margin_top'           => 5,
    //         'margin_bottom'        => 5,
    //         'margin_header'        => 0,
    //         'margin_footer'        => 10,
    //         'orientation'          => 'P',
    //         'title'                => 'Laravel mPDF',
    //         'author'               => '',
    //         'watermark'            => '',
    //         'show_watermark'       => false,
    //         'watermark_font'       => 'sans-serif',
    //         'display_mode'         => 'fullpage',
    //         'watermark_text_alpha' => 0.1,
    //         'custom_font_dir'      => '',
    //         'custom_font_data' 	   => [],
    //         'auto_language_detection'  => false,
    //         'temp_dir'               => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
    //         'pdfa' 			=> false,
    //         'pdfaauto' 		=> false,
    //     ]); 
    //     $dompdf->loadHtml($html);
    //     $dompdf->setPaper('A4', 'portrait');
    //     $dompdf->render();    
    //     return $dompdf->stream('output.pdf', ['Attachment' => false]);
    // }  

    public function print($id)
    {
        // dd($id);
        $reservation = Reservation::with('reservedRooms')->find($id);

        $pdf = FacadesPdf::loadView('reservation.myPdf', [
            'reservation_info' => $reservation,
            // 'format' => 'A4-P',
            // 'mode' => 'utf-8',       
            // 'default_font_size' => '12',
            // 'default_font' => 'FreeSerif',
            // 'margin_left' => 5,
            // 'margin_right' => 5,
            // 'margin_top' => 5,
            // 'margin_bottom' => 5,
            // 'margin_header' => 0, 
            // 'margin_footer' => 0, 
            // 'orientation' => 'P',
            // 'title' => 'Laravel mPDF',
            // 'author' => '',
            // 'watermark' => '',
            // 'show_watermark' => false,
            // 'watermark_font' => 'sans-serif',
            // 'display_mode' => 'fullpage',
            // 'watermark_text_alpha' => 0.1,
            // 'custom_font_dir' => '',
            // 'custom_font_data' => [],
            // 'auto_language_detection' => false,
            // 'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
            // 'pdfa' => false,
            // 'pdfaauto' => false,
        ]);

        // return $pdf->download('reservation - '.$reservation->id.'.pdf');
        return $pdf->stream('reservation - ' . $reservation->id . '.pdf');
    }

    public function fetchUser(Request $request)
    {
        $phone = $request->input('phone');
        $user = User::where('phone', $phone)->first();

        if ($user) {
            return response()->json(['success' => true, 'user' => $user]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function fetchData(Request $request)
    {
        $phone = $request->input('phone');
        $user = User::where('phone', $phone)->first();

        if ($user) {
            return response()->json(['success' => true, 'user' => $user]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function reservation_details($id)
    {
        $reservation = Reservation::with('reservedRooms', 'user')->find($id);
        return view('reservation.reservation_details', compact('reservation'));
    }

    public function addPayment(Request $request)
    {
        $reservation = Reservation::find($request->id);

        return view('reservation.payment_modal', compact('reservation'));
    }

    public function savePayment(Request $request)
    {

        $reservation = Reservation::where('id', $request->reservationId)->first();
        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found'], 404);
        }
        $amount = $request->amount;
        $payment_method = $request->payment_method;
        $totalPaid = $reservation->totalPaid + $amount;

        if ($totalPaid > $reservation->grand_total) {
            return response()->json(['message' => 'Paid amount cannot be greater than the grand total']);
        }


        $due = $reservation->grand_total - $totalPaid;

        $reservation->update([
            'totalPaid' => $totalPaid,
            'payment_method' => $payment_method,
            'due' => $due,
        ]);

        return response()->json(['message' => 'Payment saved successfully']);
    }

    public function change_payment_status(Request $request)
    {
        $reservation = Reservation::query()->where('id', $request->reservation_id)->first();
        $reservation->update([
            'payment_status' => $request->payment_status,
        ]);

        Session::flash('success', 'Payment Status Change Successfully!');
        return redirect()->back();
    }

    public function approvePayment(Request $request)
    {
        $paymentDetails = $request->file('invoice');
        $reservationId = $request->input('reservation_no');
        $reservation = Reservation::with('user')->find($request->reservation_id);

        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found'], 404);
        }
        if (!$reservation->user) {
            return response()->json(['error' => 'User not found for this reservation'], 404);
        }

        Mail::to($reservation->user->email)->send(new ApprovePayment($paymentDetails, $reservationId));
        if (Mail::failures()) {
            Session::flash('error', 'Failed to send mail!');
            return redirect()->back();
        } else {
            Session::flash('success', 'Mail sent successfully!');
            return redirect()->back();
        }
    }

    public function advanceReservation()
    {
        return view('reservation.advanceReservation');
    }

    public function searchRoom(Request $request)
    {
        $checkInTime = config('constant.CHECK_IN_TIME');
        $checkOutTime = config('constant.CHECK_OUT_TIME');

        $checkIn = Carbon::parse($request->check_in . ' ' . $checkInTime);
        $checkOut = Carbon::parse($request->check_out . ' ' . $checkOutTime);

        if (!empty($checkIn) && !empty($checkOut)) {
            $unavailableRooms = DB::table('room')
                ->leftJoin('reserved_rooms', function ($join) use ($checkIn, $checkOut) {
                    $join->on('room.id', '=', 'reserved_rooms.room_id')
                        ->where(function ($query) use ($checkIn, $checkOut) {
                            $query->whereBetween('reserved_rooms.check_in', [$checkIn, $checkOut])
                                ->orWhereBetween('reserved_rooms.check_out', [$checkIn, $checkOut])
                                ->orWhere(function ($innerQuery) use ($checkIn, $checkOut) {
                                    $innerQuery->where('reserved_rooms.check_in', '<', $checkIn)
                                        ->where('reserved_rooms.check_out', '>', $checkOut);
                                });
                        });
                })
                ->whereNotNull('reserved_rooms.id')
                ->pluck('room.id')
                ->toArray();

            $rooms = Room::query()
                ->where('status', 'active')
                ->get();


            return view('reservation.availableRoomCard', compact('rooms', 'unavailableRooms'));
        } else {
            $rooms = Room::query()->where('status', 'active')->get();
            return view('reservation.availableRoomCard', compact('rooms'));
        }
    }


    public function roomdetails($id, Request $request)
    {
        $totalStay = $request->totalDays;
        $room = Room::findOrFail($id);

        if ($room->discount_price != null || 0) {
            $discount = ($room->price - $room->discount_price) * $totalStay;
            $amount = ($room->discount_price) * $totalStay;
        } else {
            $discount = 0;
            $amount = $room->price * $totalStay;
        }
        return response()->json([
            'room' => $room->name,
            'rate' => ($room->price) * $totalStay,
            'discount' => $discount,
            'amount' => $amount,
            'id' => $room->id,
            'capacity' => $room->capacity,
            'totalNight' => $totalStay,
            'price' => $room->price,
            'discount_type' => $room->discount_type,
        ]);
    }

    public function saveDetails(Request $request)
    {
        $validated = $this->validate(
            $request,
            [
                'name' => 'required',
                'phone' => ['required', 'string', 'max:11'],
                'email' => 'required',
                'address' => 'required',
                'check_in' => 'required',
                'check_out' => 'required',
                'no_of_adults' => 'required',
                'no_of_kids' => 'nullable',
                'room_id' => 'required|array',
                'room_id.*' => 'exists:room,id',
                'extra_charge' => 'nullable',
                'extra_bed' => 'nullable',
                'advance' => 'nullable',
                'payment_method' => 'nullable',
                'grand_total' => 'nullable',
                'total_price' => 'nullable',
                'discount_amount' => 'nullable',
                'sub_total' => 'nullable',
                'due' => 'nullable',
                'extra_note' => 'nullable',
                'discount_type' => 'nullable',
            ]
        );

        $checkInTime = config('constant.CHECK_IN_TIME');
        $checkOutTime = config('constant.CHECK_OUT_TIME');

        $checkInDateTime = Carbon::parse($request->check_in . ' ' . $checkInTime);
        $checkOutDateTime = Carbon::parse($request->check_out . ' ' . $checkOutTime);



        $roomId = $validated['room_id'];

        $room = Room::where('id', $roomId)->first();

        $user = User::where('phone', $validated['phone'])->first();

        if (!$user) {
            $customerCount = User::where('type', 'customer')->count();
            $customerCount++;
            $customerId = 'C' . str_pad($customerCount, 2, '0', STR_PAD_LEFT);
            $user = User::query()->create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'email' => $validated['email'],
                'type' => 'customer',
                'status' => 'active',
                'password' => Hash::make('123456789'),
                'customer_id' => $customerId,
            ]);

            $customer = Customer::query()->create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'email' => $validated['email'],
                'fkUserId' => $user->id,
                'customer_id' => $customerId,
            ]);
        }

        $conflictingReservation = Reservation::with('reservedRooms')
            ->whereHas('reservedRooms', function ($query) use ($roomId, $checkInDateTime, $checkOutDateTime) {
                $query->where('room_id', $roomId)
                    ->where(function ($query) use ($checkInDateTime, $checkOutDateTime) {
                        $query->whereBetween('check_in', [$checkInDateTime, $checkOutDateTime])
                            ->orWhereBetween('check_out', [$checkInDateTime, $checkOutDateTime])
                            ->orWhere(function ($query) use ($checkInDateTime, $checkOutDateTime) {
                                $query->where('check_in', '<=', $checkInDateTime)
                                    ->where('check_out', '>=', $checkOutDateTime);
                            });
                    });
            })
            ->first();

        $reservationCount = Reservation::count();
        $reservationCount++;
        $reservationId = 'R' . str_pad($reservationCount, 2, '0', STR_PAD_LEFT);

        $discountType = null;
        foreach ($validated['discount_type'] as $type) {
            if ($type !== null) {
                $discountType = $type;
                break;
            }
        }

        if (!$conflictingReservation) {
            $reservation = Reservation::query()->create([
                'check_in' => $checkInDateTime,
                'check_out' => $checkOutDateTime,
                'no_of_adults' => $validated['no_of_adults'],
                'no_of_kids' => $validated['no_of_kids'],
                'added_by' => auth()->user()->id,
                'fkUserId' => $user->id,
                'reservation_id' => $reservationId,
                'total_price' => $validated['total_price'],
                'grand_total' => $validated['grand_total'],
                'due' => $validated['due'],
                'payment_status' => 'pending',
                'status' => 'pending',
                'extra_note' => $validated['extra_note'],
                'extra_charge' => $validated['extra_charge'],
                'discount_price' => $validated['discount_amount'],
                'discount_type' => $discountType,
                'sub_total' => $validated['sub_total'],
                'totalPaid' => $validated['advance'],
                'payment_method' => $validated['payment_method'],

            ]);

            foreach ($request->room_id as $key => $reserveItem) {
                $reserveRoom = new ReservedRoom();
                $reserveRoom->fkReserveId = $reservation->id;
                $reserveRoom->room_id = $reserveItem;
                $reserveRoom->check_in = $reservation->check_in;
                $reserveRoom->check_out = $reservation->check_out;
                $reserveRoom->save();
            }

            // $user = User::query()->create([
            //     'name' => $validated['name'],
            //     'phone' => $validated['phone'],
            //     'address' => $validated['address'],
            //     'email' => $validated['email'],

            //     'fkBookingId' => $reservation->id,
            // ]);          


            return response()->json(['message' => 'Reservation created successfully!']);
        } else {

            return response()->json(['message' => 'Invalid!']);
        }
    }

    public function findReserveInfo(Request $request)
    {
        $roomId = $request->room_id;
        $reserveId = $request->reservation_id;

        // Retrieve reservation details including user information
        $reservation = Reservation::with('user')->find($reserveId);

        // Check if reservation exists
        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found'], 404);
        }

        // Prepare HTML content for the modal body with Bootstrap classes
        $modalContent = '<div class="modal-body">';
        $modalContent .= '<div class="container">';
        $modalContent .= '<div class="row">';
        $modalContent .= '<div class="col-md-6">';
        $modalContent .= '<p class="fw-bold text-black">Customer Name:</p>';
        $modalContent .= '<p class="text-black fs-5 ">' . $reservation->user->name . '</p>';
        $modalContent .= '<p class="fw-bold text-black fs-5">Customer Email:</p>';
        $modalContent .= '<p class="text-black fs-5">' . $reservation->user->email . '</p>';
        $modalContent .= '</div>';
        $modalContent .= '<div class="col-md-6 ">';
        $modalContent .= '<p class="fw-bold text-black">Customer Phone:</p>';
        $modalContent .= '<p class="text-black fs-5">' . $reservation->user->phone . '</p>';
        $modalContent .= '<p class="fw-bold text-black">Customer Address:</p>';
        $modalContent .= '<p class="text-black fs-5">' . $reservation->user->address . '</p>';
        $modalContent .= '</div>';
        $modalContent .= '</div>'; // Close row
        $modalContent .= '<hr>'; // Add horizontal line
        $modalContent .= '<div class="row">';
        $modalContent .= '<div class="col-md-6">';
        $modalContent .= '<p class="fw-bold text-black">Grand Total:</p>';
        $modalContent .= '<p class="fw-bold fs-5">' . $reservation->grand_total . '</p>';
        $modalContent .= '</div>';
        $modalContent .= '<div class="col-md-6">';
        $modalContent .= '<p class="fw-bold text-black">Discount:</p>';
        $modalContent .= '<p class="text-black fs-5">' . $reservation->discount_price . '</p>';
        $modalContent .= '</div>';
        $modalContent .= '</div>';
        $modalContent .= '<hr>';
        $modalContent .= '<div class="row">';
        $modalContent .= '<div class="col-md-6">';
        $modalContent .= '<p class="fw-bold text-black">Payment Status:</p>';
        $modalContent .= '<p class="text-black fs-5">' . $reservation->payment_status . '</p>';
        $modalContent .= '</div>';
        $modalContent .= '<div class="col-md-6">';
        $modalContent .= '<p class="fw-bold text-black fs-5">Total Paid:</p>';
        $modalContent .= '<p class="text-black fs-5">' . ($reservation->totalPaid ?? 0) . '</p>';
        $modalContent .= '</div>';
        $modalContent .= '</div>';
        $modalContent .= '</div>';
        $modalContent .= '</div>';

        // Return the modal content as a response
        return response()->json(['modal_content' => $modalContent]);
    }
}
