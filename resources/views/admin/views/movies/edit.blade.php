@extends('adminlte::page')

@section('title', 'Edit Movie')

@section('content_header')
    <h1>
        Movies
        <small>Edit Movie [{{$movie->title}}]</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('movies.index')}}"><i class="fa fa-gamepad"></i> Movies</a>
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(function () {
            $('#lfm').filemanager('image');
            $('#lfm1').filemanager('image');
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                orientation: 'bottom',
                todayHighlight: 'TRUE',
                autoclose: true
            });
        })
    </script>
@stop

@section('css')
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
@stop

@section('content')
    <div class="row">
        <form method="post" action="{{route('movies.update',[$movie->id])}}">
            @csrf
            @method('patch')
            <div class="col-xs-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Edit Movie [{{$movie->title}}]
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="lead_actor">Lead Actor*</label>
                            <select name="movie[lead_actor]" id="lead_actor" class="form-control select2">
                                @foreach($actors as $actor)
                                    <option value="{{$actor->id}}"{{$actor->id == $movie->lead_actor ? " selected=selected" : null}}>{{$actor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="all_actors">All Actors*</label>
                            <select name="all_actor[]" id="all_actors" class="form-control select2 multiple"
                                    multiple="multiple" required="required">
                                @foreach($actors as $actor)
                                    <option value="{{$actor->id}}"
                                        @foreach($movie->actorlist as $list)
                                            @if($list->id == $actor->id)
                                                selected="selected"
                                                @break
                                                @endif
                                            @endforeach
                                    >{{$actor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="lfm">Select Cover Picture*</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                       <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                <input id="thumbnail" readonly="readonly" class="form-control" type="text"
                                       name="movie[cover]" required="required" value="{{$movie->cover}}">
                            </div>
                            <div id="holder">
                                <img src="{{$movie->cover}}" alt="" class="img-thumbnail" style="height: 120px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lfm1">Select picture*</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">
                                       <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                <input id="thumbnail1" readonly="readonly" class="form-control" type="text"
                                       name="movie[photo]" required="required" value="{{$movie->photo}}">
                            </div>
                            <div id="holder1">
                                <?php $images = explode(",", $movie->photo); ?>
                                @foreach($images as $image)
                                        <img src="{{$image}}" alt="" class="img-thumbnail" style="height:120px">
                                    @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="movie[title]">Title*</label>
                            <input type="text" name="movie[title]" class="form-control"
                                   placeholder="Enter title or movie name" required="required" value="{{$movie->title}}">
                        </div>
                        <div class="form-group">
                            <label for="movie[release_date]">Release date*</label>
                            <input type="text" name="movie[release_date]" class="form-control datepicker"
                                   placeholder="Enter release date" required="required" value="{{$movie->release_date}}">
                        </div>
                        <div class="form-group">
                            <label for="movie[producer]">Producer</label>
                            <input type="text" name="movie[producer]" class="form-control"
                                   placeholder="Enter producer" value="{{$movie->producer}}">
                        </div>
                        <div class="form-group">
                            <label for="movie[director]">Director</label>
                            <input type="text" name="movie[director]" class="form-control"
                                   placeholder="Enter director name" required="required" value="{{$movie->director}}">
                        </div>
                        <div class="form-group">
                            <label for="movie[age_limit]">Age Limit*</label>
                            <select name="movie[age_limit][]" id="movie[age_limit]" class="select2 form-control multiple" multiple="multiple" required="required">
                                <option value="G – General Audiences">G – General Audiences</option>
                                <option value="PG – Parental Guidance Suggested">PG – Parental Guidance Suggested</option>
                                <option value="PG-13 – Parents Strongly Cautioned">PG-13 – Parents Strongly Cautioned</option>
                                <option value="R – Restricted">R – Restricted</option>
                                <option value="NC-17 – Adults Only">NC-17 – Adults Only</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="movie[description]">Description*</label>
                            <textarea name="movie[description]" id="movie[description]" class="form-control"
                                      placeholder="Enter description" required="required">{{$movie->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="movie[cost]">Cost</label>
                            <input value="{{$movie->cost}}" type="number" class="form-control" name="movie[cost]" placeholder="Enter cost in NPR">
                        </div>
                        <button class="btn btn-success" type="submit">Create</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
