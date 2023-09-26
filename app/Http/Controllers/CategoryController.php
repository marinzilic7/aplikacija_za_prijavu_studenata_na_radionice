<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function dodajKategoriju(Request $request)
    {

        $data = $request->validate(
            [

                'ime' => 'required',

            ],
            [
                'ime.required' => 'Obavezno.',

            ]
        );

        $existCategory = Category::where('ime', $data['ime'])->first();

         if ($existCategory) {
            return response()->json(['email' => 'Postoji kategorija pod tim imenom'], 400);
        }

        $data['user_id'] = auth()->id();
        $user = new Category();
        $user->create($data);
        return response()->json(['message' => 'Kategorija dodana.']);

    }
}
