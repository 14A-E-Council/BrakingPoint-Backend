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
            '*' => ['date', 'category', 'odds', 'status', 'title', 'odds2', 'id'],
        ]);

    }
    public function testCreateOne()
    {

        $data = [
            'date' => '2023-04-29',
            'category' => 'race',
            'odds' => 1,
            'status' => 'ongoing',
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
            'title' => 'Test',
            'odds2' => 1
        ]);
        $bet->save();
        $response = $this->get('/api/bets/' . $bet->id);
        $response->assertStatus(200);
        $response->assertJson([
            'date' => $bet->date,
            'category' => $bet->category,
            'odds' => $bet->odds,
            'status' => $bet->status,
            'title' => $bet->title,
            'odds2' => $bet->odds2,

        ]);
        $response = $this->delete('/api/bets/' . $bet->id);

    }
    public function testPatchbet()
    {

        $bet = new Bet([
            'date' => '2023-04-29',
            'category' => 'race',
            'odds' => 1,
            'status' => 'ongoing',
            'title' => 'Test',
            'odds2' => 1
        ]);
        $data= [
            'odds' => 1.3,
            'odds2' => 5,
        ];
        $bet->save();
        $response = $this->patch('/api/bets/' . $bet->id, $data);


        $response->assertStatus(200);
        $this->assertDatabaseHas('available_bets', array_merge(['id' => $bet->id], $data));
        $response = $this->delete('/api/bets/' . $bet->id);
    }
    public function testDeletebet()
    {

        $bet = new Bet([
            'date' => '2023-04-29',
            'category' => 'race',
            'odds' => 1,
            'status' => 'ongoing',
            'title' => 'Test',
            'odds2' => 1
        ]);
        $bet->save();
        $response = $this->delete('/api/bets/' . $bet->id);


        $response->assertStatus(204);
        $this->assertDatabaseMissing('available_bets', ['id' => $bet->id]);

    }
}
