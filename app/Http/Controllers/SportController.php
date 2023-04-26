<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Sport::get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:50',
            'description' => 'max:255',
        ],
        $messages= [
            'required' => "A(z) :attribute kötelező mező",]);
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }
        $sport = Sport::create($request->all());
        return $sport;
    }

    /**
     * Display the specified resource.
     */
    public function show(Sport $id)
    {
        return $id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sport $sport)
    {
        $sport->update($request->all());
        return $sport;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $sport)
    {
        $sport->delete();
        return response(null, 204);
    }
}
