<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::all();

        return $equipments;
    }

    public function checking()
    {
        $date = Carbon::now()->toDateString();

        $equipments = Equipment::where('date_for_checking', $date)->get();

        return $equipments;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'date_for_checking'=>'required',
            

        ]);

        $equipment = Equipment::create([
            'name'=> $request->name,
            'description'=> $request->description,
            'date_for_checking'=> $request->date_for_checking,

        ]);

        return $equipment;
    }

    public function generate ($id)
    {
        $equipment = Equipment::findOrFail($id);
        $qrcode = \QrCode::size(200)
                ->generate($equipment->id.'_'.$equipment->name);

        $img_value = $equipment->id.'_'.$equipment->name;

        Equipment::where('id', $id)->update([
            'qr_value' => $img_value    
        ]);
        return $qrcode;
    }

    public function show($id)
    {
        $equipment = Equipment::find($id);

        return $equipment;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'date_for_checking'=>'required',
        ]);

        $equipment = Equipment::find($id);

        $equipmentUpdate = [
            'name'=> $request->name,
            'description'=> $request->description,
            'date_for_checking'=> $request->date_for_checking,
        ];

      
        $equipment->update($equipmentUpdate);

        return "Success";
    }

    public function destroy(Equipment $equipment)
    {
        
        $equipment->delete();

        return $equipment;
    }
}
