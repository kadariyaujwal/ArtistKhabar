<?php

namespace App\Http\Controllers;
use Image;
use File;
use App\Gallery;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function uploadImage(Request $request) {
        $this->validate($request, [
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,jpg,png,gif|max:8000'
        ]);

        if ($request->hasFile('image')) {
            $images = $request->file('image');

            $org_img = $thm_img = true;

            if( ! File::exists('images/gallery/originals/')) {
                $org_img = File::makeDirectory(public_path('images/gallery/originals/'), 0777, true);
            }
            if ( ! File::exists('images/gallery/thumbnails/')) {
                $thm_img = File::makeDirectory(public_path('images/gallery/thumbnails'), 0777, true);
            }
            if ( ! File::exists('images/gallery/small/')) {
                $thm_img = File::makeDirectory(public_path('images/gallery/small'), 0777, true);
            }
            if ( ! File::exists('images/gallery/x_small/')) {
                $thm_img = File::makeDirectory(public_path('images/gallery/x_small'), 0777, true);
            }
            if ( ! File::exists('images/gallery/medium/')) {
                $thm_img = File::makeDirectory(public_path('images/gallery/medium'), 0777, true);
            }
            if ( ! File::exists('images/gallery/large/')) {
                $thm_img = File::makeDirectory(public_path('images/gallery/large'), 0777, true);
            }

            foreach($images as $key => $image) {

                $gallery = new Gallery;

                $filename = rand(1111,9999).time().'.'.$image->getClientOriginalExtension();

                $org_path = 'images/gallery/originals/' . $filename;
                $thm_path = 'images/gallery/thumbnails/' . $filename;
                $x_small_path = 'images/gallery/x_small/' . $filename;
                $small_path = 'images/gallery/small/' . $filename;
                $medium_path = 'images/gallery/medium/' . $filename;
                $large_path = 'images/gallery/large/' . $filename;

                $gallery->image     = 'images/gallery/originals/'.$filename;
                $gallery->thumbnail = 'images/gallery/thumbnails/'.$filename;
                $gallery->name = $filename;
                $gallery->title     = $request->title ? $request->title : "Uploaded";
                $gallery->status    = $request->status ? $request->status : 20;

                if ( ! $gallery->save()) {;
                    return [
                        'error' => true,
                        'message' => 'Image can"t be saved'
                    ];
                }

                if (($org_img && $thm_img && $x_small_path && $small_path && $medium_path && $large_path) == true) {
                    Image::make($image)->save($org_path);
                    Image::make($image)->fit(270, 160, function ($constraint) {
                        $constraint->upsize();
                    })->save($thm_path);
                }
            }
        }

        return [
            'error' => false,
            'message' => $filename
        ];
    }

    public function getAllImages() {
        $images = Gallery::all();
        return Datatables::of($images)->addColumn('action', function ($image) {
            return '
                <div class="btn-group">
                    <button type="button" class="btn btn-info btn-xs dropdown-toggle btn-flat" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <button type="button" class="btn btn-info btn-xs btn-flat">Action</button>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="'.route('gallery.destroy', [$image->id]).'" class="delete">Delete</a>
                        </li>
                    </ul>
                </div>
            ';
        })->make(true);
    }

    public function index()
    {

        return view('admin.views.galleries.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,jpg,png,gif|max:8000'
        ]);

        if ($request->hasFile('image')) {
            $images = $request->file('image');

            $org_img = $thm_img = true;

            if( ! File::exists('images/gallery/originals/')) {
                $org_img = File::makeDirectory(public_path('images/gallery/originals/'), 0777, true);
            }
            if ( ! File::exists('images/gallery/thumbnails/')) {
                $thm_img = File::makeDirectory(public_path('images/gallery/thumbnails'), 0777, true);
            }
            if ( ! File::exists('images/gallery/small/')) {
                $thm_img = File::makeDirectory(public_path('images/gallery/small'), 0777, true);
            }
            if ( ! File::exists('images/gallery/x_small/')) {
                $thm_img = File::makeDirectory(public_path('images/gallery/x_small'), 0777, true);
            }
            if ( ! File::exists('images/gallery/medium/')) {
                $thm_img = File::makeDirectory(public_path('images/gallery/medium'), 0777, true);
            }
            if ( ! File::exists('images/gallery/large/')) {
                $thm_img = File::makeDirectory(public_path('images/gallery/large'), 0777, true);
            }

            foreach($images as $key => $image) {

                $gallery = new Gallery;

                $filename = rand(1111,9999).time().'.'.$image->getClientOriginalExtension();

                $org_path = 'images/gallery/originals/' . $filename;
                $thm_path = 'images/gallery/thumbnails/' . $filename;
                $x_small_path = 'images/gallery/x_small/' . $filename;
                $small_path = 'images/gallery/small/' . $filename;
                $medium_path = 'images/gallery/medium/' . $filename;
                $large_path = 'images/gallery/large/' . $filename;

                $gallery->image     = 'images/gallery/originals/'.$filename;
                $gallery->thumbnail = 'images/gallery/thumbnails/'.$filename;
                $gallery->name = $filename;
                $gallery->title     = $request->title;
                $gallery->status    = $request->status;

                if ( ! $gallery->save()) {
                    flash('Gallery could not be updated.')->error()->important();
                    return redirect()->back()->withInput();
                }

                if (($org_img && $thm_img && $x_small_path && $small_path && $medium_path && $large_path) == true) {
                    Image::make($image)->save($org_path);
                    Image::make($image)->fit(270, 160, function ($constraint) {
                        $constraint->upsize();
                    })->save($thm_path);
                }
            }
        }

        flash('Image uploaded successfully.')->success();
        return redirect()->action('GalleryController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        $image = Gallery::findOrFail($request->id);

        if ($image->status == 1) {
            $image->status = 0;
            $status = 'disabled';
        } else {
            $image->status = 1;
            $status = 'enabled';
        }

        if ( ! $image->save()) {
            flash('Image could not be reverted.')->error();
            return redirect()->route('gallery.index');
        }

        flash('Image has been successfully '.$status)->success();
        return redirect()->route('gallery.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Gallery::findOrFail($id);

        if ($post->delete()) {
            flash('Image successfully deleted.')->success();
        } else {
            flash('Image could not be deleted.')->error();
        }

        return redirect()->route('gallery.index');
    }
}
