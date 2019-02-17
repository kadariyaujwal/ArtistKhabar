@extends('adminlte::page')

@section('title', 'Create Gallery')

@section('content_header')
    <h1>
        Gallery
        <small>Edit Gallery</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('gallery.show', [$gallery->id])}}"><i class="fa fa-gamepad"></i> Edit Gallery</a>
        </li>
        <li class="active">Create</li>
    </ol>
@stop

@section('js')
    <script>
        $(function () {
            $(".select2").select2();
        })
    </script>
    <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
    <script>
        $(function () {
            $('#lfm').filemanager('image');
            $('#lfm1').filemanager('image');
        })
    </script>
@stop

@section('content')
    <div class="row">
        <form method="post" action="{{route('gallery.update',[$gallery->id])}}">
            @csrf
            @method('PATCH')
            <div class="col-xs-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Edit Gallery
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="parent_id">Select Artist</label>
                            <select name="gallery[artist_id]" id="parent_id" class="form-control select2">
                                @foreach($artists as $artist)
                                    <option value="{{$artist->id}}"{{$gallery->artist_id == $artist->id ? " selected=selected" : null}}>{{$artist->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gallery[title]">Title*</label>
                            <input type="text" name="gallery[title]" placeholder="Enter title" required="required" class="form-control" value="{{$gallery->title}}">
                        </div>
                        <div class="form-group">
                            <label for="lfm">Select Cover*</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                       <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                <input id="thumbnail" readonly="readonly" class="form-control" type="text" name="gallery[cover]" value="{{$gallery->cover}}">
                            </div>
                            <div id="holder"><img src="{{$gallery->cover}}" class="img img-responsive" style="height:120px; width: 200px;"> </div>
                        </div>
                        <div class="form-group">
                            <label for="gallery[description]">Description*</label>
                            <textarea name="gallery[description]" id="gallery[description]" class="form-control" placeholder="Enter description" required="required">{{$gallery->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="lfm1">Select Pictures*</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">
                                       <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                <?php
                                    $images = array_map(function($c) {return asset($c['url']); }, $gallery->images->toArray());
                                ?>
                                <input id="thumbnail1" readonly="readonly" class="form-control" type="text" name="gallery[images]" value="{{implode(",", $images)}}">
                            </div>
                            <div id="holder1">
                                @foreach($gallery->images as $image)
                                    <img src="{{$image->url}}" class="img img-responsive" style="height: 120px; width: 120px;">
                                @endforeach
                            </div>
                        </div>
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
