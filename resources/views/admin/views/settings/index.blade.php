@extends('adminlte::page')

@section('title','Manage App Settings')

@section('content_header')
    <h1>
        App Settings
        <small>Manage Settings</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('settings.index')}}"><i class="fa fa-gamepad"></i>Settings</a>
        </li>
        <li class="active">Manage</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">App Data</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table-responsive table" id="settings_list">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Values</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($settings as $setting)
                                <tr>
                                    <td>{{$setting->id}}</td>
                                    <td>{{$setting->title}}</td>
                                    <td>
                                        @if($setting->type)
                                            <?php
                                                $images = explode(",", $setting->value);
                                                foreach ($images as $image) {
                                                    echo "<img src='".$image."' class='img img-responsive col-md-4' style='height:80px; width:100px'>";
                                                }
                                            ?>
                                        @else
                                            {!! $setting->value !!}
                                        @endif
                                    </td>
                                    <td>{{$setting->status ? 'Active' : 'In Active'}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info btn-xs dropdown-toggle btn-flat" data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <button type="button" class="btn btn-info btn-xs btn-flat">Action</button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="{{route('settings.edit',[$setting->id])}}">Edit</a></li>
                                                <li class="divider"></li>
                                                <li>
                                                <a href="{{route('settings.destroy',[$setting->id])}}" class="delete">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$settings->links()}}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function() {
            $('#settings_list').on('click', '.delete', function (e) {
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
@endsection
