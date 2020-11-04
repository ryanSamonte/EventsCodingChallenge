<?php

use Illuminate\Http\Request;

Route::get("/events", "Api\EventController@index")->name("event.index");
Route::post("/event", "Api\EventController@store")->name("event.store");
