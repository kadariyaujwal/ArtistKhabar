@extends('adminlte::page')

@section('title', 'Manage Artist')

@section('content_header')
    <h1>
        Artist List
        <small>Manage Artist</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('artist.index')}}"><i class="fa fa-user"></i> Artist</a>
        </li>
        <li class="active">Manage</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Artist Data</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="artist_list">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Birthday</th>
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
            $('#artist_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{url('api/artistList')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'images', "render": function (data) {
                            return '<img src="' + data[0].url + '" class="img img-responsive img-circle" />';
                        }, orderable: false, searchable: false
                    },
                    {data: 'name', name: 'name'},
                    {data: 'address', name: 'address'},
                    {data: 'birthday', 'render': function (data) {
                            return $("<div/>").html(data).text();
                        }},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Delete artist data
            $('#artist_list').on('click', '.delete', function (e) {
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
