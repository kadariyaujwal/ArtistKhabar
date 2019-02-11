@extends('adminlte::page')

@section('title', 'Create Quiz')

@section('content_header')
    <h1>
        Prizes
        <small>Create Prize</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('prizes.index')}}"><i class="fa fa-gamepad"></i> Create Prize</a>
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
    <script src="{{asset('js/filemanager.js')}}"></script>
    <script>
        $(function () {
            $('#lfm').filemanager('image');
        })
    </script>
@stop

@section('content')
    <div class="row">
        <form method="post" action="{{route('prizes.store')}}">
            @csrf
            <div class="col-xs-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Create Prize
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="parent_id">Parent Quiz*</label>
                            <select name="prize[quiz_id]" id="parent_id" class="form-control select2">
                                @foreach($quizs as $quiz)
                                    <option value="{{$quiz->id}}">{{$quiz->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="prize[title]">Title*</label>
                            <input type="text" name="prize[title]" placeholder="Enter title" required="required" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="lfm">Select picture</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                       <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                <input id="thumbnail" readonly="readonly" class="form-control" type="text" name="prize[image]">
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;">
                        </div>
                        <div class="form-group">
                            <label for="prize[description]">Description*</label>
                            <textarea name="prize[description]" id="prize[description]" class="form-control" placeholder="Enter description" required="required"></textarea>
                        </div>
                        <button class="btn btn-success" type="submit">Create</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
