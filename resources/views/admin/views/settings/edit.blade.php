@extends('adminlte::page')

@section('title','Update App Settings')

@section('content_header')
    <h1>
        App Settings
        <small>Edit Settings</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('settings.index')}}"><i class="fa fa-gamepad"></i>Settings</a>
        </li>
    <li class="active">Edit</li>
    </ol>
@stop

@section('js')
    <script src="{{asset('js/filemanager.js')}}"></script>
    <script>
        $(function () {
            $('#lfm').filemanager('image');

            $('.type-change').change(function () {
               var value = $(this).val();
               if(value == 1) {
                   $('.image-type').show();
                   $('.text-type').hide();
               } else {
                   $('.image-type').hide();
                   $('.text-type').show();
               }
            });
        })
    </script>

@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">App Data Update</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form action="{{route('settings.update',[$app->id])}}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="settings[title]">Title*</label>
                        <input type="text" name="settings[title]" placeholder="Enter title.." class="form-control" value="{{$app->title}}">
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="settings[type]" value="1" class="type-change" {{$app->type == 1 ? "checked='checked'" : null}}> Image type
                            </label>
                            <label>
                                <input type="radio" name="settings[type]" value="0" class="type-change" {{$app->type == 0 ? "checked='checked'" : null}}> Text type
                            </label>
                        </div>
                        <div class="form-group text-type" style="{{$app->type == 1 ? "display:none;" : null}}">
                            <label for="settings[value]">Values*</label>
                        <textarea name="settings[value]" id="settings[values]" placeholder="Enter Values" class="form-control">{{$app->value}}</textarea>
                        </div>
                        <div class="form-group image-type" style="{{$app->type == 0 ? "display:none;" : null}}">
                            <label for="lfm">Select picture *</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                       <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                            <input id="thumbnail" readonly="readonly" class="form-control" type="text" name="settings[images][]" required="required" value="{{$app->value}}">
                            </div>
                        <img id="holder" style="margin-top:15px;max-height:100px;" src="{{$app->value}}">
                        </div>
                        <div class="radio">
                                <label>
                                        <input type="radio" name="settings[status]" value="1" {{$app->status == 1 ? "checked='checked'" : null}}> Active
                                    </label>
                                    <label>
                                        <input type="radio" name="settings[status]" value="0" {{$app->status == 0 ? "checked='checked'" : null}}> In Active
                                    </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update!!</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
