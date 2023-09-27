<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    public function dodajRadionicu(Request $request)
    {

        $data = $request->validate(
            [

                'ime' => 'required',
                'opis' => 'required',
                'category_id' => 'required',
                'user_id' => ''

            ],
            [
                'ime.required' => 'Obavezno.',
                'opis.required' => 'Obavezno.',
                'category_id.required' => 'Obavezno.',

            ]
        );

        $existWorkshop = Workshop::where('ime', $data['ime'])->first();

         if ($existWorkshop) {
            return response()->json(['workshop' => 'Postoji radionica pod tim imenom'], 400);
        }

        $data['user_id'] = auth()->id();
        $user = new Workshop();
        $user->create($data);
        return response()->json(['message' => 'Radionica dodana.']);

    }
    public function getRadionicu(){
        $radionica = Workshop::with('user','category')->get();
        $brojRadionica = Workshop::count();
        return response()->json(['radionica' => $radionica, 'brojRadionica' => $brojRadionica]);
    }

    public function deleteRadionicu($id){
        $radionica = Workshop::find($id);
        $radionica->delete();
    }

    public function urediRadionicu(Request $request, $id){

        $radionica = Workshop::findOrFail($id);
        $data = $request->validate([
            'ime' => 'required|string',
            'opis' => 'required|string',

        ]);

        $radionica->ime=$data['ime'];
        $radionica->opis=$data['opis'];
        $radionica->save();
        return response()->json([
            'poruka' => 'Radionica uspjesno uređena',
            'radionica' => $radionica,
        ]);
    }
}
