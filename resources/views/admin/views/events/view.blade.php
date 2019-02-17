@extends('adminlte::page')

@section('content')
   <div class="row">
       <div class="col-md-7">
            <div class="box">
                    <div class="box-header bg-blue">
                        <h3 class="box-title">{{$event->title}}</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-striped">
                            <tr>
                                <td>Title</td>
                                <td>{{$event->title}}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>{{$event->description}}</td>
                            </tr>
                            <tr>
                                <td>Location</td>
                                <td>{{$event->location}}</td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td>{{$event->date}}</td>
                            </tr>
                            <tr>
                                <td>Artists</td>
                                <td>
                                    @foreach($event->artists as $artist)
                                        <a style="margin-right:10px" href="{{route('artist.show',$artist->id)}}">{{$artist->name}}</a>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
       </div>
       <div class="col-md-5">
            <div class="box">
                <div class="box-header bg-blue">
                    <h3 class="box-title">Gallery</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                            @foreach($event->photos as $photo)
                            <div class="col-md-4" style="margin-top:10px;">
                                    <img src="{{$photo->path}}" alt="" class="img img-thumbnanil img-responsive" height="200" width="200">
                            </div>
                            @endforeach
                    </div>
                </div>
            </div>
       </div>
   </div>
@stop
