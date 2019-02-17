<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Movie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Bsdate;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAllMovies()
    {
        $movies = Movie::with('actorlist','leadactor')->orderBy('release_date','DESC')->get();
        return Datatables::of($movies)->addColumn('action', function ($movie) {
            return '
                <div class="btn-group">
                    <button type="button" class="btn btn-info btn-xs dropdown-toggle btn-flat" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <button type="button" class="btn btn-info btn-xs btn-flat">Action</button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="'.route('movies.show',[$movie->id]).'">View</a></li>
                        <li><a href="'.route('movies.edit',[$movie->id]).'">Edit</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="'.route('movies.destroy', [$movie->id]).'" class="delete">Delete</a>
                        </li>
                    </ul>
                </div>
            ';
        })
            ->editColumn('release_date', function (Movie $movie) {
                $date = (object)Carbon::createFromFormat("Y-m-d", $movie->release_date);
                $date = Bsdate::eng_to_nep($date->year,$date->month,$date->day);
                return $date['day'].', '.$date['date'].' '.$date['nmonth'].', '.$date['year'];
            })
            ->editColumn('photo', function (Movie $movie) {
                return "<img src='".url($movie->photo)."' class='img img-responsive'>";
            })
            ->make(true);
    }


    public function index()
    {
        return view('admin.views.movies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['actors'] = Artist::all();
        return view('admin.views.movies.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->movie;
        $movieModel = new Movie;
        foreach ($data as $key => $movie) {
            if($key == 'cover') {
                $movie = parse_url($movie)['path'];
                $movieModel->$key = $movie;
            }
            if($key == 'photo') {
                $movie = explode(",", $movie);
                foreach ($movie as $k => $m) {
                    $movie[$k] = parse_url($m)['path'];
                }
                $movie = implode(",", $movie);
                $movieModel->$key = $movie;
            }
            if($key == 'age_limit') {
                $movieModel->$key = implode(',',$movie);
            } else {
                $movieModel->$key = $movie;
            }
        }
        $movieModel->save();
        $artist = Artist::find($request->all_actor);
        $movieModel->actorlist()->attach($artist);
        \Session::flash('success', 'Movie is created successfully.');
        return redirect()->action('MovieController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['movie'] = Movie::with('actorlist', 'leadactor')->whereIn('id',[$id])->get()->first();

        return view('admin.views.movies.view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['actors'] = Artist::all();
        $data['movie'] = Movie::with('actorlist', 'leadactor')->whereIn('id',[$id])->get()->first();
        return view('admin.views.movies.edit')->with($data);
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
        $data = $request->movie;
        $movieModel = Movie::with('actorlist')->find($id);
        foreach ($data as $key => $movie) {
            if($key == 'cover') {
                $movie = parse_url($movie)['path'];
                $movieModel->$key = $movie;
            }
            if($key == 'photo') {
                $movie = explode(",", $movie);
                foreach ($movie as $k => $m) {
                    $movie[$k] = parse_url($m)['path'];
                }
                $movie = implode(",", $movie);
                $movieModel->$key = $movie;
            }
            if($key == 'age_limit') {
                $movieModel->$key = implode(',',$movie);
            } else {
                $movieModel->$key = $movie;
            }
        }
        $movieModel->save();
        $artist = Artist::find($request->all_actor);
        $movieModel->actorlist()->sync($artist);
        \Session::flash('success', 'Movie is updated successfully.');
        return redirect()->action('MovieController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Movie::find($id);
        $delete = $data->delete();
        if($delete) {
            \Session::flash('success', 'Movie is deleted successfully.');
        } else {
            \Session::flash('error', 'Some internal error occurred.');
        }
        return $delete;
    }
}
