<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Gallery;
use App\GalleryImage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['galleries'] = Gallery::with('images')->paginate(10);
        return view('admin.views.galleries.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['artists'] = Artist::all();
        return view('admin.views.galleries.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gallery = new Gallery;
        $covers = explode(',', $request->gallery['cover']);
        foreach ($covers as $key => $cover) {
            $covers[$key] = parse_url($cover)['path'];
            break;
        }
        $gallery->cover = implode(',', $covers);
        $gallery->title = $request->gallery['title'];
        $gallery->description = $request->gallery['description'];
        $gallery->artist_id = $request->gallery['artist_id'];

        $gallery->save();


        $pictures = explode(',', $request->gallery['images']);
        foreach ($pictures as $key => $picture) {
            $pictures[$key] = [
                'url' => parse_url($picture)['path'],
                'gallery_id' => $gallery->id
            ];
        }
        $gallery->images()->createMany($pictures);

        flash('Gallery is saved!')->success();
        return redirect()->route('gallery.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['gallery'] = Gallery::with('images', 'artist')->find($id);
        return view('admin.views.galleries.view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['artists'] = Artist::all();
        $data['gallery'] = Gallery::with('images')->find($id);
        return view('admin.views.galleries.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gallery = Gallery::with('images')->find($id);
        $covers = explode(',', $request->gallery['cover']);
        foreach ($covers as $key => $cover) {
            $covers[$key] = parse_url($cover)['path'];
            break;
        }
        $gallery->cover = implode(',', $covers);
        $gallery->title = $request->gallery['title'];
        $gallery->description = $request->gallery['description'];
        $gallery->artist_id = $request->gallery['artist_id'];

        $gallery->save();

        $gallery->images()->where('gallery_id', $gallery->id)->delete();

        $pictures = explode(',', $request->gallery['images']);
        foreach ($pictures as $key => $picture) {
            $pictures[$key] = [
                'url' => parse_url($picture)['path'],
                'gallery_id' => $gallery->id
            ];
        }
        $gallery->images()->createMany($pictures);

        flash('Gallery is Modified!')->success();
        return redirect()->route('gallery.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Gallery::with('images')->find($id);
        $data->images()->where('gallery_id', $id)->delete();
        $delete = $data->delete();
        if($delete) {
            flash('Gallery is deleted successfully.')->success();
        } else {
            flash('Some internal error occurred.')->error();
        }
        return $delete;
    }
}
