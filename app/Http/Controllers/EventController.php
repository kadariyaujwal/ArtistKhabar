<?php

namespace App\Http\Controllers;

use App\Event;
use App\Artist;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;
use App\Http\Requests\EventRequest;
use Yajra\DataTables\DataTables;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(){
        $events =Event::all();
        return DataTables::of($events)
        ->addColumn('actions',function($row){
            return '
                <div class="row">
                <div class="btn-group">
                <button type="button" class="btn btn-info btn-xs dropdown-toggle btn-flat" data-toggle="dropdown" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <button type="button" class="btn btn-info btn-xs btn-flat">Action</button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="'.route('events.show',[$row->id]).'">View</a></li>
                    <li><a href="'.route('events.edit',[$row->id]).'">Edit</a></li>
                    <li class="divider"></li>
                    <li>
                        <a href="'.route('events.destroy', [$row->id]).'" class="delete">Delete</a>
                    </li>
                </ul>
            </div>
                </div>
                
            ';
        })
        ->addColumn('photo',function($row){
            if($row->photos()->where('cover','1')){
                return $row->photos()->where('cover','1')->first()['path'];
            }
            else if($row->photos()->where('cover','0')){
                return $row->photos()->where('cover','0')->first()['path'];
            }
            else{
                return 'No photo';
            }
        })
        ->make(true);
    }
    public function index()
    {
        //
       return view('admin.views.events.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.views.events.create');
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
        // if($request->hasFile('main_picture')){
        //     $eventPhoto = EventPhoto::create([
        //         'cover'=>true,
        //         'img_path'=>Storage::url()
        //     ]);
        //     $event->save($eventPhoto);
        // }
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
        return view('admin.views.events.view',compact('event'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        //
        $artists = Artist::all();
        $event = Event::with(['photos','artists'])->findOrFail($id);
        return view('admin.views.events.edit',compact('event','artists'));
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
            'date'=>$request->date,
        ]);
        if($request->artists){
            $event->artists()->sync($request->artists);
        }
        return redirect(route('events.index'));
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
