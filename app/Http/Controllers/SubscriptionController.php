<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with('customer', 'membership')->get();

        return $subscriptions;
    }

    public function store(Request $request)
    {
        $request->validate([
            'membership_id'=>'required',
            'customer_id'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'status'=>'required',
            

        ]);

        $subscription = Subscription::create([
            'membership_id'=>$request->membership_id,
            'customer_id'=>$request->customer_id,
            'total'=>$request->total,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'status'=>$request->status,

        ]);

        $start = Carbon::parse($subscription->start_date);
        $end = Carbon::parse($subscription->end_date);

        $days = $start->diffInDays($end);
        $days++;

        $membership = Membership::find($subscription->membership_id);

        $per_day_fee = (int)$membership->fee;

        $total_fee = $per_day_fee * (int)$days;

        $subscription->total = $total_fee;
        $subscription->save();

        return $subscription;
    }

    public function show($id)
    {
        $subscription = Subscription::find($id);

        return $subscription;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'membership_id'=>'required',
            'customer_id'=>'required',
            'total'=> 'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'status'=>'required',
        ]);

        $subscription = Subscription::find($id);

        $subscriptionUpdate = [
            'membership_id'=> $request->membership_id,
            'customer_id'=> $request->customer_id,
            'total'=>$request->total,
            'start_date'=> $request->start_date,
            'end_date'=> $request->end_date,
            'status'=>$request->status,


        ];


        $subscription->update($subscriptionUpdate);

        return "Success";
    }

    public function destroy(Subscription $subscription)
    {
        
        $subscription->delete();

        return $subscription;
    }
}
