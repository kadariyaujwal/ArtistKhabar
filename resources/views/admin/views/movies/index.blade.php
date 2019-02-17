@extends('adminlte::page')

@section('title', 'Manage Movies')

@section('content_header')
    <h1>
        Movies List
        <small>Manage Movies</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('movies.index')}}"><i class="fa fa-gamepad"></i>Movies</a>
        </li>
        <li class="active">Manage</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Movies Data</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="movies_list">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Release Date</th>
                                <th>Title</th>
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
            $('#movies_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{url('api/movieList')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'release_date', "render": function (data) {
                            return $("<div/>").html(data).text();
                        }, orderable: true, searchable: false
                    },
                    {data: 'title', name: 'title'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Delete artist data
            $('#movies_list').on('click', '.delete', function (e) {
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
