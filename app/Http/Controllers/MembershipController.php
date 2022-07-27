<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::all();

        return $memberships;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'fee'=>'required',
            
            

        ]);

        $membership = Membership::create([
            'name'=> $request->name,
            'fee'=> $request->fee,

        ]);

        return $membership;
    }

    public function show($id)
    {
        $membership = Membership::find($id);

        return $membership;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'fee'=>'required',
        ]);

        $membership = Membership::find($id);

        $membershipUpdate = [
            'name'=> $request->Name,
            'fee'=> $request->fee,

        ];


        $membership->update($membershipUpdate);

        return "Success";
    }

    public function destroy(Membership $membership)
    {
        
        $membership->delete();

        return $membership;
    }
}
