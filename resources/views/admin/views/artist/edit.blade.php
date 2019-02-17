@extends('adminlte::page')

@section('title', 'Edit Artist')

@section('content_header')
    <h1>
        Artist List
        <small>Edit Artist</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('artist.index')}}"><i class="fa fa-user"></i> Artist</a>
        </li>
        <li class="active">Edit</li>
    </ol>
@stop

@section('css')
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
@stop

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                orientation: 'bottom',
                todayHighlight:'TRUE',
                autoclose: true
            });
        })
    </script>
    <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
    <script>
        $(function () {
            $('#lfm').filemanager('image');
            $('#lfm_cover').filemanager('image');
        })
    </script>
@stop

@section('content')
    <div class="row">
        <form method="post" action="{{route('artist.update',[$artist->id])}}" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="col-xs-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Edit ({{$artist->name}})
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">Full name*</label>
                            <input type="text" name="artist[name]" placeholder="Enter fullname" class="form-control"
                                   required="required" id="name" value="{{$artist->name}}">
                        </div>
                        <div class="form-group">
                            <label for="address">Address*</label>
                            <input type="text" name="artist[address]" placeholder="Enter address" class="form-control"
                                   required="required" id="name" value="{{$artist->address}}">
                        </div>
                        <div class="form-group">
                            <label for="birthday">Birthday*</label>
                            <input type="text" name="artist[birthday]" placeholder="Enter birthday"
                                   class="form-control datepicker" required="required" value="{{$artist->birthday}}">
                        </div>
                        <div class="form-group">
                            <label for="lfm">Select picture *</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                       <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                <input id="thumbnail" readonly="readonly" class="form-control" type="text" name="artist[picture]" required="required" value="{{$artist->picture}}">
                            </div>
                            <div id="holder">
                                @foreach($artist->images as $image)
                                    <img src="{{$image->url}}" alt="" style="height: 120px;">
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lfm_cover">Select cover picture *</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm_cover" data-input="thumbnail_cover" data-preview="holder_cover" class="btn btn-primary">
                                       <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                <input id="thumbnail_cover" class="form-control" type="text" name="artist[cover_picture]" required="required" readonly="readonly" value="{{$artist->cover_picture}}">
                            </div>
                            <div id="holder_cover">
                                <img src="{{$artist->cover_picture}}" alt="" style="height: 120px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="artist[website]">Website </label>
                            <input type="text" name="artist[website]" class="form-control" placeholder="Enter website." value="{{$artist->website}}">
                        </div>
                        <div class="form-group">
                            <label for="artist[facebook]">Facebook </label>
                            <input type="text" name="artist[facebook]" class="form-control"
                                   placeholder="Enter Facebook ID." value="{{$artist->facebook}}">
                        </div>
                        <div class="form-group">
                            <label for="artist[twitter]">Twitter </label>
                            <input type="text" name="artist[twitter]" class="form-control"
                                   placeholder="Enter twitter ID." value="{{$artist->twitter}}">
                        </div>
                        <div class="form-group">
                            <label for="artist[email]">Email </label>
                            <input type="text" name="artist[email]" class="form-control" placeholder="Enter Email ID." value="{{$artist->email}}">
                        </div>
                        <div class="form-group">
                            <label for="artist[bio]">BIO* </label>
                            <textarea name="artist[bio]" id="artist[bio]" class="form-control" placeholder="Enter BIO"
                                      required="required">{{$artist->bio}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="artist[meta_desc]">Meta Description </label>
                            <input type="text" name="artist[meta_desc]" class="form-control"
                                   placeholder="Enter Meta description." value="{{$artist->meta_desc}}">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Create" class="btn btn-success pull-left">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
