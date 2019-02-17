@extends('adminlte::page')

@section('content')
   <div class="col-md-8">
    <div class="box">
        <div class="box-header bg-blue">
            <h3 class="box-title">Edit Event</h3>
        </div>
        <div class="box-body">
            <form action="{{route("events.update",$event->id)}}" method="post">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" value="{{$event->title}} ">
                </div>
                <div class="form-group">
                    <label for="description">Descriptioin</label>
                    <input type="textarea" name="description" class="form-control" value="{{$event->description}} ">
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" value="{{$event->location}} " class="form-control">
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="text" name="date" class="form-control datepicker" value="{{$event->date}}">
                </div>
                <div class="form-group">
                    <label for="lfm">Select cover picture *</label>
                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                        <input id="thumbnail" readonly="readonly" class="form-control" type="text" name="main_picture"
                               required="required" value="{{$event->photos->first()->path}}">
                    </div>
                    <div id="holder">
                        <img src="{{$event->photos->where('cover', 1)->first()->path}}" alt="" class="img img-responsive" style="height: 120px;">
                    </div>
                </div>
                <div class="form-group">
                    <label for="artists[]">Artists</label>
                    <select name="artists[]" class="select2 form-control" style="width:100%;" multiple>
                        @foreach($artists as $artist)
                        <option value="{{$artist->id}}" class="form-control" {{$event->contains_artist($artist)}}>{{$artist->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="lfm1">Select other pictures </label>
                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                        <input id="thumbnail1" readonly="readonly" class="form-control" type="text" name="pictures" value="{{implode(",", array_map(function($c) {return asset($c['path']); }, $event->photos->where('cover', 0)->toArray()))}}">
                    </div>
                    <div id="holder1" class="row">
                        @foreach($event->photos->where('cover', 0) as $e)
                            <img src="{{$e->path}}" alt="" class="img img-responsive col-md-4" style="height: 120px;">
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{route('events.index')}} " class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
   </div>
@stop
@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script>
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            orientation: 'bottom',
            todayHighlight: 'TRUE',
            autoclose: true
        });
    </script>

@stop
