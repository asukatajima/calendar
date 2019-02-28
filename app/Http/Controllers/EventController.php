<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Calendar;


class EventController extends Controller
{
        public function index()
        {
            $events = [];
            $data = Event::all();
            if($data->count()) {
                foreach ($data as $key => $value) {
                    $events[] = Calendar::event(
                        $value->title,
                        true,
                        new \DateTime($value->startdt),
                        new \DateTime($value->enddt
                        .' +1 day'),
                        null,
                        // Add color and link on event
                     [
                         'color' => '#ff0000',
                         'url' => 'pass here url and any route',
                     ]
                    );
                }
            }
            $calendar = Calendar::addEvents($events);
            return view('welcome', compact('calendar'));
        }
            
        public function store(Request $request)
       {
           
            $this->validate($request, [
                'startdt' => 'required|max:10', 
                'enddt' => 'required|max:10',
                'content' => 'required|max:10',
            ]);
            
            $event = new Event();
            $event->startdt = $request->startdt; 
            $event->enddt = $request->enddt; 
            $event->content = $request->content;
            $event->user_id = $request->user()->id;
            if (\Auth::id() === $event->user_id) {
                $event->save();
            }
            return redirect('/');
        }

}
