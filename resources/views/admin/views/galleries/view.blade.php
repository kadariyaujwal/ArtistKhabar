@extends('adminlte::page')
@section('title', 'View Gallery')

@section('content_header')
    <h1>
        Gallery
        <small>View Gallery</small>
    </h1>
    <ol class="breadcrumb">
        <li class="active">View Gallery</li>
    </ol>
@stop
@section('content')
   <div class="row">
       <div class="col-md-7">
            <div class="box">
                    <div class="box-header bg-blue">
                        <h3 class="box-title">{{$gallery->title}}</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-striped">
                            <tr>
                                <td>Title</td>
                                <td>{{$gallery->title}}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>{{$gallery->description}}</td>
                            </tr>
                            <tr>
                                <td>Artist</td>
                                <td>{{$gallery->artist->name}}</td>
                            </tr>
                            <tr>
                                <td>Cover Picture</td>
                                <td>
                                    <img src="{{$gallery->cover}}" class="img img-responsive" style="height: 120px; widows: 200px;"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
       </div>
       <div class="col-md-5">
            <div class="box">
                <div class="box-header bg-blue">
                    <h3 class="box-title">Pictures</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        @foreach($gallery->images as $image)
                            <img src="{{$image->url}}" alt="{{$image->url}}" class="img img-responsive col-md-4" style="margin-bottom: 10px;">
                        @endforeach
                    </div>
                </div>
            </div>
       </div>
   </div>
@stop
