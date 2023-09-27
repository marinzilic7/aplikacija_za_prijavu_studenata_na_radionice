<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function dodajPrijavu(Request $request)
    {

        $data = $request->validate(
            [


                'workshop_id' => 'required',
                'user_id' => ''

            ],
            [

                'workshop_id.required' => 'Obavezno.',

            ]
        );

        $data['user_id'] = auth()->id();

        $existUser = Member::where('user_id', $data['user_id'])
            ->where('workshop_id', $data['workshop_id'])
            ->first();

        if ($existUser) {
            return response()->json(['workshop' => 'Prijavljeni ste vec na ovu radionicu!'], 400);
        }


        $user = new Member();
        $user->create($data);
        return response()->json(['message' => 'Uspjesna prijava.']);
    }
}
