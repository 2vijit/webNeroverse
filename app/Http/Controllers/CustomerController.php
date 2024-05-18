<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function show()
    {
        return view('customer.index');
    }

    /**
     * @throws Exception
     */
    public function list()
    {
        $customer = Customer::query()->get();
        return datatables()->of($customer)

            ->setRowAttr([
                'align' => 'center',
            ])
            ->make(true);
    }

    public function create()
    {
        $shipmentZones = ShipmentZone::query()->where('status', 'active')->get();
        return view('customer.create', compact('shipmentZones'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validate($request, [
            'firstName' => 'required|string|max:50',
            'lastName' => 'nullable|string|max:50',
            'phone' => 'required|string|max:20|unique:user',
            'email' => 'required|email|max:50|unique:user',
            'customerImage' => 'nullable|image|mimes:jpeg,png,jpg',
            'billingAddress' => 'required|string',
            'shippingAddress' => 'nullable|string',
            'fkShipmentZoneId' => 'required|numeric',
            'status' => 'required|string|max:45',
        ]);

        DB::transaction(function () use ($validated) {
            $address = Address::query()->create([
                'billingAddress' => $validated['billingAddress'],
                'shippingAddress' => $validated['shippingAddress'],
            ]);

            $user = User::query()->create([
                'firstName' => $validated['firstName'],
                'lastName' => $validated['lastName'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'password' => Hash::make('12345678'),
                'fkUserTypeId' => 2,
            ]);

            Customer::query()->create([
                'fkUserId' => $user->userId,
                'phone' => $validated['phone'],
                'customerImage' => isset($validated['customerImage']) ? $this->save_image('customerImage', $validated['customerImage']) : null,
                'fkAddressId' => $address->addressId,
                'fkShipmentZoneId' => $validated['fkShipmentZoneId'],
                'status' => $validated['status'],
            ]);
        });

        Session::flash('success', 'Customer Created Successfully!');
        return redirect()->route('customer.show');
    }

    public function edit($customerId)
    {
        $customer = Customer::with('user', 'address')->where('customerId', $customerId)->first();
        $shipmentZones = ShipmentZone::query()->where('status', 'active')->get();
        return view('customer.edit', compact('customer', 'shipmentZones'));
    }

    public function update(Request $request, $customerId): RedirectResponse
    {
        $customer = Customer::query()->where('customerId', $customerId)->first();

        if (!empty($customer)) {
            $user = User::query()->where('userId', $customer->fkUserId)->first();

            if (!empty($user)) {
                $validated = $this->validate($request, [
                    'firstName' => 'required|string|max:50',
                    'lastName' => 'nullable|string|max:50',
                    'phone' => 'required|string|max:20|unique:user,phone,' . $user->userId . ',userId',
                    'email' => 'required|email|max:50|unique:user,email,' . $user->userId . ',userId',
                    'customerImage' => 'nullable|image|mimes:jpeg,png,jpg',
                    'billingAddress' => 'required|string',
                    'shippingAddress' => 'nullable|string',
                    'fkShipmentZoneId' => 'required|numeric',
                    'status' => 'required|string|max:45',
                ]);

                DB::transaction(function () use ($validated, $customer, $user) {
                    Address::query()->where('addressId', $customer->fkAddressId)->update([
                        'billingAddress' => $validated['billingAddress'],
                        'shippingAddress' => $validated['shippingAddress'],
                    ]);

                    $user->update([
                        'firstName' => $validated['firstName'],
                        'lastName' => $validated['lastName'],
                        'phone' => $validated['phone'],
                        'email' => $validated['email'],
                        'password' => $user->password ?? Hash::make('12345678'),
                        'fkUserTypeId' => 2,
                    ]);

                    if (empty($validated['customerImage'])) {
                        $customerImage = $customer->customerImage;
                    } else {
                        $this->deleteImage($customer->customerImage);
                        $customerImage = $this->save_image('customerImage', $validated['customerImage']);
                    }

                    $customer->update([
                        'phone' => $validated['phone'],
                        'customerImage' => $customerImage,
                        'fkShipmentZoneId' => $validated['fkShipmentZoneId'],
                        'status' => $validated['status'],
                    ]);
                });
            }
        }

        Session::flash('success', 'Customer Updated Successfully!');
        return redirect()->route('customer.show');
    }

    public function delete(Request $request): JsonResponse
    {
        $customer = Customer::query()->where('customerId', $request->customerId)->first();
        if (!empty($customer)) {
            $customer->delete();
        }
        return response()->json();
    }
}
