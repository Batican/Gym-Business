<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getData(){

        $employees = User::where('type', User::Employee)->count();
        $customers = Customer::all()->count();
        $equipments = Equipment::all()->count();


        $year = Carbon::now()->year;

        $months = ['01','02','03','04','05','06','07','08','09','10','11','12'];

        


        foreach($months as $month){
           $sales = Payment::whereYear('date',$year)->whereMonth('date',$month)->get();

           $total = 0;

           foreach($sales as $sale){
                $payment = (int)$sale->amount;

                $total = $total + $payment ;

           }

           $results[] = $total;
        }
        
        $month_sales[] = $results;

        return [
            'employees' => $employees,
            'customers' => $customers,
            'equipments' => $equipments,
            'sales' => $month_sales
        ];
    }
}
