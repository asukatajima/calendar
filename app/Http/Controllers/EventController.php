<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Calendar;


class EventController extends Controller
{
       public function index()
    {
       $data = [];
       if(\Auth::check()){
           $user =\Auth::user();
           $events = $user->events()->orderBy('created_at','desc')->get();
            return view('events.index', [
                'events' => $events,
            ]);
            
       }
       return view('welcome',$data);
    }
        
        public function create()
        {
            $event = new Event;
       
            return view('events.create', [
            'event' => $event,
         ]);
        }
            
        public function store(Request $request)
       {
            $this->validate($request, [
                'startdt' => 'required|max:20', 
                'enddt' => 'required|max:20',
                'content' => 'required|max:20',
            ]);
            
            $event = new Event();
            $event->startdt = $request->startdt; 
            $event->enddt = $request->enddt; 
            $event->content = $request->content;
            $event->user_id = $request->user()->id;
            if (\Auth::id() === $event->user_id) {
                $event->save();
            }
            
            return redirect()->route('events.index');
        }


        public function ajaxUpdate(Request $request)
        {
             $event = Event::with('client')->findOrFail($request->event_id);
             $event->update($request->all());

             return response()->json(['event' => $event]);
        }
}
