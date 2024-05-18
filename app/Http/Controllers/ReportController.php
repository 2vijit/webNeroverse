<?php
namespace App\Http\Controllers;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function show()
    {
        return view('report.index');
    }

    public function list(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Reservation::with(['reservedRooms.room']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $report = $query->get();

        return datatables()->of($report)
            ->addColumn('room_names', function ($report) {
                // Check if reservedRooms is null
                if ($report->reservedRooms) {
                    $roomNames = $report->reservedRooms->pluck('room.name')->toArray();
                    return implode(', ', $roomNames);
                } else {
                    return 'No rooms reserved';
                }
            })
            ->make(true);
    }





    public function store(Request $request)
    {
    }

    public function create()
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }


    public function delete(Request $request)
    {
    }
}
