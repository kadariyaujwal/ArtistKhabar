@extends('adminlte::page')

@section('title', 'Manage Artist')

@section('content_header')
    <h1>
        Artist Profile
        <small>{{$profile->name}}</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('artist.index')}}"><i class="fa fa-user"></i>Manage Artist</a>
        </li>
        <li class="active">View ({{$profile->name}})</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{$profile->picture}}"
                         alt="{{$profile->name}}">

                    <h3 class="profile-username text-center">{{$profile->name}}</h3>

                    <p class="text-muted text-center">{{$profile->birthday}}</p>
                    <p class="text-muted text-center">{{$profile->address}}</p>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">About {{$profile->name}}</h3>
                </div>
                <div class="box-body">
                    @if(strlen($profile->website) > 1)
                        <strong>Website</strong><br>
                        <a class="text-muted text-blue" href="{{$profile->website}}" target="_blank">
                            {{$profile->website}}
                        </a>
                    @endif
                    @if(strlen($profile->facebook) > 1)
                        <br>
                        <strong>Facebook</strong><br>
                        <a class="text-muted text-blue" href="{{$profile->facebook}}" target="_blank">
                            {{$profile->facebook}}
                        </a>
                    @endif
                    @if(strlen($profile->twitter) > 1)
                        <br>
                        <strong>Twitter</strong><br>
                        <a class="text-muted text-blue" href="{{$profile->twitter}}" target="_blank">
                            {{$profile->twitter}}
                        </a>
                    @endif
                    @if(strlen($profile->email) > 1)
                        <br>
                        <strong>Email</strong><br>
                        <p class="text-muted">
                            {{$profile->email}}
                        </p>
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-9">
            <div style="background: url('{{$profile->cover_picture}}') center center; height: 220px"></div>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#details" data-toggle="tab" aria-expanded="true">Details</a>
                    </li>
                    <li class="">
                        <a href="#pictures" data-toggle="tab" aria-expanded="false">Pictures</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="details" class="tab-pane active">
                        <p class="text-justify">
                            {!! $profile->bio !!}
                        </p>
                    </div>
                    <div id="pictures" class="tab-pane">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aperiam architecto at aut consequuntur esse id impedit incidunt, laboriosam, modi molestias nobis, quaerat quibusdam reiciendis soluta suscipit voluptates? Accusantium, doloremque.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

