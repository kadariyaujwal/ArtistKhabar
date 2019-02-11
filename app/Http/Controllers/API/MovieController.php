<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Movie;
use App\Http\Resources\Movie as MovieResource;
class MovieController extends Controller
{
    //
    public function index(){
        return MovieResource::collection(Movie::with(['leadActor','actorList'])->get());
    }

    public function released(){
        return MovieResource::collection(Movie::with(['actorList','leadActor'])->where('release_date','>',Carbon::today()->toDateString())->get());
    }
}
