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
            return response()->json(['category' => 'Postoji kategorija pod tim imenom'], 400);
        }

        $data['user_id'] = auth()->id();
        $user = new Category();
        $user->create($data);
        return response()->json(['message' => 'Kategorija dodana.']);

    }

    public function getCategory(){
        $category = Category::get();
        $brojKategorija = Category::count();
        return response()->json(['category' => $category, 'brojKategorija' => $brojKategorija]);
    }

    public function deleteCategory($id){
        $category = Category::find($id);
        $category->delete();
        return response()->json(['message' => 'Kategorija je uspešno izbrisana']);
    }
}
