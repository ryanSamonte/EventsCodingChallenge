<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;

use App\Http\Requests\StoreEvent;

use App\Event;

class EventController extends Controller
{
    // GET: /api/events
    public function index(){
        $event_count = Event::count();

        if($event_count == 0){
            return response()->json([], 200);
        }else{
            $event = Event::select("name", "from_date", "to_date", "days")->first();

            $inclusive_dates = getInclusiveDates($event["from_date"], $event["to_date"]);

            $allowed_dates = [];

            foreach($inclusive_dates as $key => $value){
                if(in_array(extractDate($value, "w"), explode(",", $event["days"]))){
                    array_push($allowed_dates, $value);
                }
            }

            $events = [];

            foreach($allowed_dates as $key => $value){
                array_push($events, array("title" => $event["name"], "start" => $value));
            }

            return response()->json($events, 200);
        }
    }

    // POST: api/event PARAMS: event_name, from_date, to_date, days
    public function store(StoreEvent $request){
        $validated = $request->validated();
        $is_successful = false;

        DB::beginTransaction();

        try{
            $event_count = Event::count();

            if($event_count == 0){
                $event = new Event;

                $event->name = $validated["event_name"];
                $event->from_date = $validated["from_date"];
                $event->to_date = $validated["to_date"];
                $event->days = implode(",", $validated["days"]);

                $is_successful = $event->save();
            }else{
                $event = Event::first();

                $event->name = $validated["event_name"];
                $event->from_date = $validated["from_date"];
                $event->to_date = $validated["to_date"];
                $event->days = implode(",", $validated["days"]);

                $is_successful = $event->save();
            }

            DB::commit();

            if($is_successful){
                return response()->json([
                    "data" => [
                        "is_success" => true,
                        "message" => "Event successfully saved"
                    ]], 201);
            }else{
                return response()->json([
                    "data" => [
                        "is_success" => false,
                        "message" => "Event not saved. Something went wrong"
                ]], 500);
            }
        }catch(Throwable $error){
            DB::rollback();

            return response()->json([
                "data" => [
                    "is_success" => false,
                    "message" => "Event not saved. Something went wrong"
            ]], 500);
        }
    }


}
