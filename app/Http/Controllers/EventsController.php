<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;

class EventsController extends Controller
{
    public function getEventsList($user_id){
        $tickets = Ticket::where('account_id', $user_id)->get();
    
        $eventIds = $tickets->pluck('event_id');
    
        $events = Event::whereIn('id', $eventIds)->get();

        $events->load('organizer');
    
        return response()->json($events, 200);
    }

    public function getAllEventsList(){
        $events = Event::all();
        $events->load('organizer');

        return response()->json($events, 200);
    }
}

