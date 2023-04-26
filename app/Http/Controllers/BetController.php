<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Bet::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'min:1|max:255',
            'date' => 'required|date',
            'category' => 'required|min:1|max:255',
            'odds' => 'required|numeric',
            'odds2' => 'numeric',
            'status' => 'required|min:1|max:255',
            'sportID' => 'numeric'

        ],$messages= [
            'required' => "A(z) :attribute kötelező mező",
            'date' => "Az dátum nem megfelelő formátumú.",
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }

        $bet = Bet::create($request->all());
        return $bet;
    }

    /**
     * Display the specified resource.
     */
    public function show(Bet $id)
    {
        return $id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bet $bet)
    {
        $bet->update($request->all());
        return $bet;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bet $bet)
    {
        $bet->delete();
        return response(null, 204);
    }
}
