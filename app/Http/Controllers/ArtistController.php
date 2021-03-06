<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Gallery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Bsdate;

class ArtistController extends Controller
{
    public function getAllArtist()
    {
        $artists = Artist::with('movies','images')->get();
        return Datatables::of($artists)->addColumn('action', function ($user) {
            return '
                <div class="btn-group">
                    <button type="button" class="btn btn-info btn-xs dropdown-toggle btn-flat" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <button type="button" class="btn btn-info btn-xs btn-flat">Action</button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="'.route('artist.show',[$user->id]).'">View</a></li>
                        <li><a href="'.route('artist.edit',[$user->id]).'">Edit</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="'.route('artist.destroy', [$user->id]).'" class="delete">Delete</a>
                        </li>
                    </ul>
                </div>
            ';
        })
            ->editColumn('birthday', function (Artist $artist) {
                $birthdate = (object)Carbon::createFromFormat("Y-m-d", $artist->birthday);
                $birthdate = Bsdate::eng_to_nep($birthdate->year,$birthdate->month,$birthdate->day);
                return $birthdate['day'].', '.$birthdate['date'].' '.$birthdate['nmonth'].', '.$birthdate['year'];
            })
            ->removeColumn('password')
            ->make(true);
    }

    public function index()
    {
        return view('admin.views.artist.manage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.views.artist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $artist = new Artist;
        foreach($request->artist as $key => $value) {
            if($key == 'picture') {
                $images = explode(",", $value);
                foreach ($images as $k => $image) {
                    $images[$k] = parse_url($image)['path'];
                }
                $value = implode(",", $images);
            }
            if ($key == 'cover_picture') {
                $images_cover = explode(",", $value);
                if(is_array($images_cover)) {
                    $value = parse_url($images[0])['path'];
                }
            }
            $artist->$key = $value;
        }
        $artist->save();
        if(is_array($images)) {
            $imageData = [];
            foreach ($images as $image) {
                $imageData[] = [
                    'artist_id' => $artist->id,
                    'url' => $image
                ];
            }
            $artist->images()->createMany($imageData);
        }
        \Session::flash('success', 'Artist is created successfully.');
        return redirect()->action('ArtistController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artist = Artist::with('images','gallery')->find($id);
        return view('admin.views.artist.view',[
            'profile' => $artist
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['artist'] = Artist::with('images','gallery')->find($id);
        return view('admin.views.artist.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $artist = Artist::find($id);
        foreach($request->artist as $key => $value) {
            if($key == 'picture') {
                $images = explode(",", $value);
                foreach ($images as $k => $image) {
                    $images[$k] = parse_url($image)['path'];
                }
                $value = implode(",", $images);
            }
            if ($key == 'cover_picture') {
                $images_cover = explode(",", $value);
                if(is_array($images_cover)) {
                    $value = parse_url($images[0])['path'];
                }
            }
            $artist->$key = $value;
        }
        $artist->save();
        $artist->images()->where('artist_id', $artist->id)->delete();
        if(is_array($images)) {
            $imageData = [];
            foreach ($images as $image) {
                $imageData[] = [
                    'artist_id' => $artist->id,
                    'url' => $image
                ];
            }
            $artist->images()->createMany($imageData);
        }
        \Session::flash('success', 'Artist is created successfully.');
        return redirect()->action('ArtistController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Artist::find($id);
        $delete = $data->delete();
        if($delete) {
            \Session::flash('success', 'Artist is deleted successfully.');
        } else {
            \Session::flash('error', 'Some internal error occurred.');
        }
        return $delete;
    }
}
