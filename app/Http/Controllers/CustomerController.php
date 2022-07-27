<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return $customers;
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname'=>'required',
            'lastname'=>'required',
            'phone_number'=>'required',
            'gender'=>'required',
            'age'=>'required',
            'email'=>'required|email',

        ]);

        $customer = Customer::create([
            'firstname'=> $request->firstname,
            'lastname'=> $request->lastname,
            'phone_number'=> $request->phone_number,
            'gender'=> $request->gender,
            'age'=> $request->age,
            'email'=> $request->email,


        ]);

        return $customer;
    }

    public function show($id)
    {
        $customer = Customer::find($id);

        return $customer;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'firstname'=>'required',
            'lastname'=>'required',
            'phone_number'=>'required',
            'gender'=>'required',
            'age'=>'required',
            'email'=>'required|email',
        ]);

        $customer = Customer::find($id);

        $customerUpdate = [
            'firstname'=> $request->firstname,
            'lastname'=> $request->lastname,
            'phone_number'=> $request->phone_number,
            'gender'=> $request->gender,
            'age'=> $request->age,
            'email'=> $request->email,
        ];


        $customer->update($customerUpdate);

        return "Success";
    }

    public function destroy(Customer $customer)
    {
        
        $customer->delete();

        return $customer;
    }
}
