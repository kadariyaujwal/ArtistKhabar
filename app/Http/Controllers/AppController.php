<?php

namespace App\Http\Controllers;

use App\App;
use App\Artist;
use App\Http\Resources\ArtistResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
//use Session;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getSettings($data = false) {
        if($data) {
            $settings = App::where('status', 1)->where($data)->get();
        } else {
            $settings = App::where('status', 1)->get();
        }
        $finalSettings = new \stdClass();
        foreach ($settings as $setting) {
            $title = $setting->title;
            if($setting->type) {
                $setting->value = explode(",", $setting->value);
            }
            $finalSettings->$title = $setting;
        }
        $final['data'] = $finalSettings;
        return $final;
    }

    public function syncApp() {
        $today = new Carbon('today');
        $nextmonth = new Carbon('next month');
        $data['birthday'] = new ArtistResource(Artist::with('images')->whereBetween('birthday',[$today->toDateTimeString(),$nextmonth->toDateTimeString()])->orderBy('birthday','ASC')->limit(5)->get());
        $data['settings'] = $this->getSettings();
        return $data;
    }


    public function index()
    {
        $data['settings'] = App::paginate(10);
        return view('admin.views.settings.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.views.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $setting = new App;
        if($request->settings['type'] == '0') {
            //Text type
            $setting->title = $request->settings['title'];
            $setting->type = 0;
            $setting->value = $request->settings['value'];
        } else {
            $setting->title = $request->settings['title'];
            $setting->type = 1;
            $images = explode(",", $request->settings['images']);
            foreach ($images as $key => $image) {
                $images[$key] = parse_url($image)['path'];
            }
            $setting->value = implode(",", $images);
        }
        $setting->save();

        \Session::flash('success', 'App Setting created successfully.');
        return redirect()->action('AppController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['app'] = App::find($id);
        return view('admin.views.settings.edit')->with($data);
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
        $setting = App::find($id);
        if($request->settings['type'] == '0') {
            //Text type
            $setting->title = $request->settings['title'];
            $setting->type = 0;
            $setting->value = $request->settings['value'];
        } else {
            $setting->title = $request->settings['title'];
            $setting->type = 1;
            $images = explode(",", $request->settings['images']);
            foreach ($images as $key => $image) {
                $images[$key] = parse_url($image)['path'];
            }
            $setting->value = implode(",", $images);
        }
        $setting->status = $request->settings['status'];
        $setting->save();
        \Session::flash('success', 'App Setting updated successfully.');
        return redirect()->action('AppController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = App::find($id);
        $delete = $data->delete();
        if($delete) {
            \Session::flash('success', 'App data is deleted successfully.');
        } else {
            \Session::flash('error', 'Some internal error occurred.');
        }
        return $delete;
    }
}
