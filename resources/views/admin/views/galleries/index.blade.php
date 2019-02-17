@extends('adminlte::page')

@section('title', 'Manage Artist')

@section('content_header')
    <h1>
        Gallery
        <small>Manage Gallery</small>
    </h1>
    <ol class="breadcrumb">
        <li class="active">Manage Gallery</li>
    </ol>
@stop

@section('content')
    @include('flash::message')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Manage your galleries.
                    </h3>
                </div>
                <div class="box-body">
                    <div class="table table-responsive">
                        <table class="table table-striped" id="gallery_list">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Cover</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($galleries as $gallery)
                                <tr>
                                    <td>{{$gallery->id}}</td>
                                    <td>{{$gallery->title}}</td>
                                    <td>{{$gallery->description}}</td>
                                    <td>
                                        <img src="{{$gallery->cover}}" class="img img-responsive" style="height: 140px; width: 200px;"/>
                                    </td>
                                    <td>
                                        {{date('M d, Y')}}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info btn-xs dropdown-toggle btn-flat" data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <button type="button" class="btn btn-info btn-xs btn-flat">Action</button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="{{route('gallery.show', [$gallery->id])}}">View</a></li>
                                                <li><a href="{{route('gallery.edit', [$gallery->id])}}">Edit</a></li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{route('gallery.destroy', [$gallery->id])}}" class="delete">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$galleries->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            $('#gallery_list').on('click', '.delete', function (e) {
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
