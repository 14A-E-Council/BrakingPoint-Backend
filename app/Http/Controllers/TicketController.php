<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Ticket::get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
   
        $validator = Validator::make($request->all(),[
            'status' => 'required|min:1|max:255',
            'debt' => 'required|numeric',
            'sum_odds' => 'required|numeric',
            'races' => 'required|min:1|max:255',
            'payment_date' => 'date',
            'betID' => 'required|numeric',
            'userID' => 'required|numeric'
        ],
        $messages= [
            'required' => "A(z) :attribute kötelező mező",
            'date' => "Az dátum nem megfelelő formátumú."]);
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }
        $ticket = Ticket::create($request->all());

        return $ticket;
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $id)
    {
        return $id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $ticket->update($request->all());
        return $ticket;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response(null, 204);
    }
}
