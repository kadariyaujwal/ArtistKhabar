@extends('adminlte::page')

@section('title', 'Manage Quiz')

@section('content_header')
    <h1>
        Questions List
        <small>Manage Questions</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('question.index')}}"><i class="fa fa-gamepad"></i>Quiz Question</a>
        </li>
        <li class="active">Manage</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Quiz Question Data</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="question_list">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Quiz Name</th>
                                <th>Question</th>
                                <th>Options</th>
                                <th>Correct Answer</th>
                                <th>Time</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            var base_url= '{{url("/")}}';
            $('#question_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{url('api/questionList')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'quiz', "render": function (data) {
                            return `<a href="${base_url}/quiz/${data.id}">${data.title}</a>`;
                        }, orderable: false, searchable: false
                    },
                    {data: 'question', name: 'question'},
                    {data: 'options', name: 'options'},
                    {data: 'correct_answer', name: 'correct_answer'},
                    {data: 'time', name: 'time'},
                    {data: 'date', 'render': function (data) {
                            return $("<div/>").html(data).text();
                        }},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Delete artist data
            $('#question_list').on('click', '.delete', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = $(this).attr("href");
                // confirm then
                if (confirm('Are you sure you want to delete this?')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {method: '_DELETE', submit: true}
                    }).always(function (data) {
                        window.location.reload();
                    });
                }else
                    alert("You have cancelled!");
            });
        })
    </script>
@stop
