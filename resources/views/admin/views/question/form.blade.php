@extends('adminlte::page')

@section('title', 'Create Question')

@section('content_header')
    <h1>
        Question Quiz
        <small>Create Question</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('question.index')}}"><i class="fa fa-gamepad"></i>Question List</a>
        </li>
        <li class="active">Create</li>
    </ol>
@stop

@section('css')
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <style>
        .bootstrap-tagsinput {
            width: 100%;
            border-radius: 0px;
        }
    </style>
@stop

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script>
        $(function () {
            $(".select2").select2();
            $("#correct_answer").select2();
            var optionsSelector = $('#options');
            optionsSelector.change(function () {
                $("#correct_answer").empty().trigger('change');
                var answers = $(this).tagsinput('items');
                $.each(answers, function (index, value) {
                    var option = new Option(value, index, true, true);
                    $("#correct_answer").append(option).trigger('change');
                })
            });
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                orientation: 'bottom',
                todayHighlight: 'TRUE',
                autoclose: true
            });
        })
    </script>
@stop

@section('content')
    <div class="row">
        <form method="post" action="{{route('question.store')}}">
            @csrf
            <div class="col-xs-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Create Quiz Question
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="parent_id">Quiz*</label>
                            <select name="question[quiz_id]" id="parent_id" class="form-control select2">
                                @foreach($quizs as $quiz)
                                    <option value="{{$quiz->id}}">{{$quiz->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="question[question]">Question*</label>
                            <input type="text" name="question[question]" placeholder="Enter question"
                                   required="required" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="answers">Answers (Seperated by comma)*</label>
                            <input type="text" data-role="tagsinput" class="form-control" name="question[options]"
                                   id="options" required="required">
                        </div>
                        <div class="form-group">
                            <label for="date">Date for *</label>
                            <input type="text" name="question[date]" class="form-control datepicker" placeholder="Select date for quiz" required="required">
                        </div>
                        <div class="form-group">
                            <label for="correct_answer">Correct Answer*</label>
                            <select name="question[correct_answer]" id="correct_answer" class="form-control" required="required">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="time">Time (in second)*</label>
                            <input type="number" class="form-control" value="15" placeholder="Enter time in second." name="question[time]" required="required">
                        </div>
                        <button class="btn btn-success" type="submit">Create</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
