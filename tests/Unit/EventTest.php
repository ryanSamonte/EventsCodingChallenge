<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Event;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateOrUpdateEvent(){
        $event_count = Event::count();

        $from_date = strtotime("2020-10-30");
        $from_date_formatted = date('Y-m-d', $from_date);

        $to_date = strtotime("2020-11-05");
        $to_date_formatted = date('Y-m-d', $to_date);

        $days = [1, 2, 3, 4];

        $data = [
            "event_name" => "My Event",
            "from_date" => $from_date_formatted,
            "to_date" => $to_date_formatted,
            "days" => $days
        ];

        $json_data = [
            "data" => [
                "is_success" => true,
                "message" => "Event successfully saved"
            ]
        ];

        if($event_count == 0) {
            $this->post(route("event.store"), $data, array('HTTP_X-Requested-With' => 'XMLHttpRequest'))
                ->assertStatus(201)
                ->assertExactJson($json_data);
        }else{
            $event = Event::first();

            $json_data = [
                "data" => [
                    "is_success" => true,
                    "message" => "Event successfully saved"
                ]
            ];

            $this->post(route("event.store"), $data, array('HTTP_X-Requested-With' => 'XMLHttpRequest'))
                ->assertstatus(200)
                ->assertExactJson($json_data);
        }
    }

    public function testEventList(){
        $event_count = Event::count();

        if($event_count == 0) {
            $data = [];

            $this->get(route("event.index"))
                ->assertStatus(200)
                ->assertExactJson($data);
        }else{
            $this->get(route("event.index"))
            ->assertStatus(200)
            ->assertJsonStructure([
                    "title",
                    "start"
            ]);
        }
    }
}
