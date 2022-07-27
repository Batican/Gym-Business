<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();

        return $employees;
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
            'password'=>'required',

        ]);

        $employee = Employee::create([
            'firstname'=> $request->firstname,
            'lastname'=> $request->lastname,
            'phone_number'=> $request->phone_number,
            'gender'=> $request->gender,
            'age'=> $request->age,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),


        ]);

        return $employee;
    }

    public function show($id)
    {
        $employee = Employee::find($id);

        return $employee;
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

        $employee = Employee::find($id);

        $employeeUpdate = [
            'firstname'=> $request->firstname,
            'lastname'=> $request->lastname,
            'phone_number'=> $request->phone_number,
            'gender'=> $request->gender,
            'age'=> $request->age,
            'email'=> $request->email,
        ];

        if($request->password){
            $employeeUpdate["password"] = bcrypt($request->password);
        }

        $employee->update($employeeUpdate);

        return "Success";
    }

    public function destroy(Employee $employee)
    {
        
        $employee->delete();

        return $employee;
    }
}
