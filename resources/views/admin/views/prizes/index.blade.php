@extends('adminlte::page')

@section('title', 'Manage Quiz')

@section('content_header')
    <h1>
        Prizes List
        <small>Manage Prizes</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('prizes.index')}}"><i class="fa fa-gamepad"></i>Prizes</a>
        </li>
        <li class="active">Manage</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Prizes Data</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="prize_list">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Parent Quiz</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Photo</th>
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
            $('#prize_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{url('api/prizesList')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'quiz', "render": function (data) {
                            return data.title;
                        }, orderable: false, searchable: false
                    },
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'image', "render": function (data) {
                            return $("<div/>").html(data).text();
                        }, orderable: false, searhable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Delete artist data
            $('#prize_list').on('click', '.delete', function (e) {
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
