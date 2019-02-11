@extends('adminlte::page')

@section('title', 'Create Quiz')

@section('content_header')
    <h1>
        Quiz List
        <small>Create Create</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('quiz.index')}}"><i class="fa fa-gamepad"></i> Create Quiz</a>
        </li>
        <li class="active">Create</li>
    </ol>
@stop

@section('css')
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
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
        })
    </script>
@stop

@section('content')
    <div class="row">
        <form method="post" action="{{route('quiz.store')}}">
            @csrf
            <div class="col-xs-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Create Quiz
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="parent_id">Parent Quiz*</label>
                            <select name="quiz[parent_id]" id="parent_id" class="form-control select2">
                                @if(sizeof($parent_quiz) == 0)
                                <option value="1">Main Quiz</option>
                                @endif
                                @foreach($parent_quiz as $quiz)
                                    <option value="{{$quiz->id}}">{{$quiz->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quiz[title]">Title*</label>
                            <input type="text" name="quiz[title]" placeholder="Enter title" required="required" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="lfm">Select picture *</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                       <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                </span>
                                <input id="thumbnail" readonly="readonly" class="form-control" type="text" name="quiz[picture]" required="required">
                            </div>
                            <div id="holder"></div>
                        </div>
                        <div class="form-group">
                            <label for="quiz[description]">Description*</label>
                            <textarea name="quiz[description]" id="quiz[description]" class="form-control" placeholder="Enter description"></textarea>
                        </div>
                        <button class="btn btn-success" type="submit">Create</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
