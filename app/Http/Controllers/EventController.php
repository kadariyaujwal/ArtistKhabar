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
    public function list() {
        $events = Event::all();
        return DataTables::of($events)->addColumn('actions',function($row) {
            return '<div class="row">
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
        $data['artists'] = Artist::all();
        return view('admin.views.events.create')->with($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $event = Event::create([
            'location' => $request->location,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date
        ]);

        $event->artists()->attach($request->artists);

        $cover = $request->main_picture;
        $covers = explode(",", $cover);
        if(is_array($covers)) {
            foreach($covers as $cover) {
                $temp = parse_url($cover);
                $path = $temp['path'];
                $cover = $path;
                break;
            }
        }
        $event->photos()->create([
            'event_id' => $event->id,
            'cover' => 1,
            'path' => $cover
        ]);
        $photos = explode(',', $request->pictures);
        $pictures = [];
        if(is_array($photos)) {
            foreach($photos as $photo) {
                $temp = parse_url($photo);
                $path = $temp['path'];
                $pictures[] = [
                    'event_id' => $event->id,
                    'cover' => 0,
                    'path' => $path
                ];
            }
        }
        if(count($pictures) > 0) {
            $event->photos()->createMany($pictures);
        }
        // Edited by Razeev
        \Session::flash('success', 'Event created successfully.');
        return redirect()->action('EventController@index');
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
        return view('admin.views.events.view', compact('event'));
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
        $event->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'location'=>$request->description,
            'date'=>$request->date,
        ]);
        if($request->artists){
            $event->artists()->sync($request->artists);
        }
        $pictures = explode(",", $request->pictures);
        $covers = explode(",", $request->main_picture);
        foreach ($pictures as $key => $picture) {
            $pictures[$key] = [
                "path"=> parse_url($picture)['path'],
                "event_id" => $event->id,
                "cover" => 0
                ];
        }
        foreach ($covers as $key => $picture) {
            $covers[$key] = [
                "path"=> parse_url($picture)['path'],
                "event_id" => $event->id,
                "cover" => 1
                ];
            break;
        }

        $event->photos()->where('event_id', $event->id)->delete();
        $event->photos()->createMany($pictures);
        $event->photos()->createMany($covers);
        return redirect(route('events.index'));
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
