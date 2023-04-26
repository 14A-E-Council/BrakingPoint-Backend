<?php

namespace App\Listeners;

use App\Events\TicketStatusChanged;
use App\Models\Ticket;

class PayoutWinningBets
{
    /**
     * Handle the event.
     *
     * @param  TicketStatusChanged  $event
     * @return void
     */
    public function handle(TicketStatusChanged $event)
    {
        if ($event->ticket->status === 'win') {
            // Get all the users who bet on this ticket
            $bettingUsers = $event->ticket->bets()->pluck('user_id');

            // Calculate the payout amount per user
            $payoutPerUser = $event->ticket->payout / $bettingUsers->count();

            // Loop through the betting users and pay out their winnings
            foreach ($bettingUsers as $userId) {
                $event->ticket->calculatePayout();
                // Pay out the winnings to the user
                // This is where you would implement the code to actually pay out the user
            }
        }
    }
}