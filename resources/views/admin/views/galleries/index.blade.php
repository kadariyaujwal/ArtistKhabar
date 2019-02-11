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
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Manage your galleries.
                    </h3>
                </div>
                <div class="box-body">
                    <form method="POST" action="{{ route('gallery.store') }}" enctype="multipart/form-data"  class="form-inline">
                        <p><small>Note: Total size of uploading files shold not be greater than 8 MB.</small></p>
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" name="image[]"  accept="image/png, image/jpeg, image/jpg, image/gif"  class="form-control" multiple/>
                            <input type="text" name="title" placeholder="Image description (Optional)" class="form-control"/>
                            <select name="status" class="form-control">
                                <option value="1">Publish</option>
                                <option value="0">Save in draft</option>
                            </select>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-success" style="margin-bottom: 0px;">Upload</button>
                        </div>
                    </form>
                    <br>
                    <hr>
                    <div class="table table-responsive">
                        <table class="table table-striped" id="gallery_list">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Thumbnail</th>
                                    <th>Image</th>
                                    <th>Status</th>
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
            $('#gallery_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{url('api/galleriesList')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'thumbnail', "render": function (data) {
                            return '<img src="' + data + '" class="img img-responsive img-circle" />';
                        }, orderable: false, searchable: false
                    },
                    {data: 'title', name: 'title'},
                    {data: 'status', 'render': function (data) {
                            return data ? 'Active' : 'Inactive';
                        }},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Delete artist data
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
