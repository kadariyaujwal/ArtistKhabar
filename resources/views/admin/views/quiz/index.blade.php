@extends('adminlte::page')

@section('title', 'Manage Quiz')

@section('content_header')
    <h1>
        Quiz List
        <small>Manage Quiz</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('quiz.index')}}"><i class="fa fa-gamepad"></i>Quiz</a>
        </li>
        <li class="active">Manage</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Quiz Data</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="quiz_list">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Parent Category</th>
                                <th>Title</th>
                                <th>Description</th>
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
            $('#quiz_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{url('api/quizList')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'parent', "render": function (data) {
                            return data.title;
                        }, orderable: false, searchable: false
                    },
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Delete artist data
            $('#quiz_list').on('click', '.delete', function (e) {
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
