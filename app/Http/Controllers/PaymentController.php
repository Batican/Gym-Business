<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('customer')->get();

        return $payments;
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_for'=>'required',
            'amount'=>'required',
            'customer_id'=>'required',
            'date'=>'required',
            

        ]);

        $payment = Payment::create([
            'payment_for'=> $request->payment_for,
            'amount'=> $request->amount,
            'customer_id'=> $request->customer_id,
            'date'=> $request->date,

        ]);

        return $payment;
    }

    public function show($id)
    {
        $payment = Payment::find($id);

        return $payment;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'payment_for'=>'required',
            'amount'=>'required',
            'customer_id'=>'required',
            'date'=>'required',
        ]);

        $payment = Payment::find($id);

        $paymentUpdate = [
            'payment_for'=> $request->payment_for,
            'amount'=> $request->amount,
            'customer_id'=> $request->customer_id,
            'date'=> $request->date,
        ];


        $payment->update($paymentUpdate);

        return "Success";
    }

    public function payment(Request $request)
    {
        $date = Carbon::now()->toDateString();

        $request->validate([
            'amount'=>'required',
            'customer_id'=>'required',
        ]);

        $payment = Payment::create([
            'payment_for'=> 'Subscription',
            'amount'=> $request->amount,
            'customer_id'=> $request->customer_id,
            'date'=> $date,

        ]);

        $subscription = Subscription::find($request->id);

        $subscription->update([
            'status'=> Subscription::Paid,  
        ]);


        return $payment;
    }


    public function destroy(Payment $payment)
    {
        
        $payment->delete();

        return $payment;
    }
}
