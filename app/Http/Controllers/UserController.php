<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function adminIndex()
    {
        $admins = User::where('type', User::Admin)->get();

        return $admins;
    }

    public function employeeIndex()
    {
        $employees = User::where('type', User::Employee)->get();

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
            'type' =>'required'

        ]);

        $user = User::create([
            'firstname'=> $request->firstname,
            'lastname'=> $request->lastname,
            'phone_number'=> $request->phone_number,
            'gender'=> $request->gender,
            'age'=> $request->age,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
            'type'=> $request->type,


        ]);

        return $user;
    }

    public function show($id)
    {
        $user = User::find($id);

        return $user;
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

        $user = User::find($id);

        $userUpdate = [
            'firstname'=> $request->firstname,
            'lastname'=> $request->lastname,
            'phone_number'=> $request->phone_number,
            'gender'=> $request->gender,
            'age'=> $request->age,
            'email'=> $request->email,
            'type'=> $request->type,
        ];

        if($request->password){
            $userUpdate["password"] = bcrypt($request->password);
        }

        $user->update($userUpdate);

        return "Success";
    }

    public function destroy(User $user)
    {
        
        $user->delete();

        return $user;
    }
}
