@extends('adminlte::page')

@section('title','Create App Settings')

@section('content_header')
    <h1>
        App Settings
        <small>Create Settings</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('settings.index')}}"><i class="fa fa-gamepad"></i>Settings</a>
        </li>
    <li class="active">Create</li>
    </ol>
@stop

@section('js')
    <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
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
                    <h3 class="box-title">App Data Create</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form action="{{route('settings.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="settings[title]">Title*</label>
                            <input type="text" name="settings[title]" placeholder="Enter title.." class="form-control">
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="settings[type]" value="1" class="type-change"> Image type
                            </label>
                            <label>
                                <input type="radio" name="settings[type]" value="0" class="type-change" checked="checked"> Text type
                            </label>
                        </div>
                        <div class="form-group text-type">
                            <label for="settings[value]">Values*</label>
                            <textarea name="settings[value]" id="settings[values]" placeholder="Enter Values" class="form-control"></textarea>
                        </div>
                        <div class="form-group image-type" style="display: none;">
                            <label for="lfm">Select picture *</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                       <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                <input id="thumbnail" readonly="readonly" class="form-control" type="text" name="settings[images]" required="required">
                            </div>
                            <div id="holder" style="margin-top:15px;"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create!!</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
