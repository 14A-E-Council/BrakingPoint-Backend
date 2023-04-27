<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Bet;

class BetsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetAll()
    {
        $response = $this->get('/api/bets');
    
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['date', 'category', 'odds', 'status', 'sportID', 'title', 'odds2', 'available_betID',],
        ]);

    }
    public function testCreateOne()
    {

        $data = [
            'date' => '2023-04-29',
            'category' => 'race',
            'odds' => 1,
            'status' => 'ongoing',
            'sportID' => 1,
            'title' => 'Test',
            'odds2' => 1
        ];
        $response = $this->post('/api/bets', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('available_bets', $data);


    }
    public function testGetOne()
    {

        $bet = new Bet([
            'date' => '2023-04-29',
            'category' => 'race',
            'odds' => 1,
            'status' => 'ongoing',
            'sportID' => 1,
            'title' => 'Test',
            'odds2' => 1
        ]);
        $bet->save();
        $response = $this->get('/api/bets/' . $bet->available_betID);
        $response->assertStatus(200);
        $response->assertJson([
            'date' => $bet->date,
            'category' => $bet->category,
            'odds' => $bet->odds,
            'status' => $bet->status,
            'sportID' => $bet->sportID,
            'title' => $bet->title,
            'odds2' => $bet->odds2,

        ]);
        $response = $this->delete('/api/bets/' . $bet->available_betID);

    }
    public function testPatchbet()
    {

        $bet = new Bet([
            'date' => '2023-04-29',
            'category' => 'race',
            'odds' => 1,
            'status' => 'ongoing',
            'sportID' => 1,
            'title' => 'Test',
            'odds2' => 1
        ]);
        $data= [
            'odds' => 1.3,
            'odds2' => 5,
        ];
        $bet->save();
        $response = $this->patch('/api/bets/' . $bet->available_betID, $data);


        $response->assertStatus(200);
        $this->assertDatabaseHas('available_bets', array_merge(['available_betID' => $bet->available_betID], $data));
        $response = $this->delete('/api/bets/' . $bet->available_betID);
    }
    public function testDeletebet()
    {

        $bet = new Bet([
            'date' => '2023-04-29',
            'category' => 'race',
            'odds' => 1,
            'status' => 'ongoing',
            'sportID' => 1,
            'title' => 'Test',
            'odds2' => 1
        ]);
        $bet->save();
        $response = $this->delete('/api/bets/' . $bet->available_betID);


        $response->assertStatus(204);
        $this->assertDatabaseMissing('available_bets', ['available_betID' => $bet->available_betID]);

    }
}
