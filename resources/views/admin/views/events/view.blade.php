@extends('adminlte::page')

@section('content')
   <div class="row">
       <div class="col-md-7">
            <div class="box">
                    <div class="box-header bg-blue">
                        <h3 class="box-title">Event: {{$event->title}}</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-striped">
                            @foreach($event->toArray() as $key=>$value)
                            @if(gettype($value)!='array')
                            <tr>  
                                <th>{{$key}}</th>
                                <td>{{$value}} </td>
                            </tr>
                            @endif
                            @endforeach
                            @if($event->artists->toArray())
                            <th>Artists</th>
                            <td>
                            @foreach($event->artists as $artist)
                                <a style="margin-right:10px" href="{{route('artist.show',$artist->id)}}">{{$artist->name}}</a>
                            @endforeach
                            </td>
                            @endif
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