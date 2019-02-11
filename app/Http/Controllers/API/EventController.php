<?php

namespace App\Http\Controllers\API;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return EventResource::collection(Event::with(['artists','photos'])->orderBy('date','asc')->paginate(10));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return 'Create event view';
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        //
        $event = Event::create([
            'location'=>$request->location,
            'title'=>$request->title,
            'description'=>$request->description,
            'date'=>$request->date
        ]);
        return response()->json([
            'message'=>'Event Created successfully',
            'event'=>new EventResource($event)
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::with(['artists','photos'])->findOrFail($id);
        return new EventResource($event);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */

    public function edit(Event $event)
    {
        //
        return 'event edit view';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, Event $event)
    {
        //
        $event->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'location'=>$request->description,
            'date'=>$request->date
        ]);
        return response()->json([
            'message'=>'Event updated successfully',
            'event'=>new EventResource($event),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json([
            'message'=>'Event deleted successfully',
        ]);
    }
}
