@extends('adminlte::page')
@section('title', 'Veiw Movie | '.$movie->title)

@section('content_header')
    <h1>
        View Movie
        <small>{{$movie->title}}</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('movies.index')}}"><i class="fa fa-gamepad"></i> Movies</a>
        </li>
        <li class="active">View</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Movie Data ({{$movie->title}})</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table-striped table table-responsive">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Content</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Lead Actor</td>
                                <td>{{$movie->leadactor->name}}</td>
                            </tr>
                            <tr>
                                <td>Movie Name</td>
                                <td>{{$movie->title}}</td>
                            </tr>
                            <tr>
                                <td>Photo</td>
                                <td>
                                    <div class="row">
                                    <?php $images = explode(',', $movie->photo); ?>
                                        @foreach($images as $image)
                                            <img src="{{url($image)}}" class="img img-responsive col-md-4">
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
<tr>
    <td>Cover Picture</td>
    <td>
        <img src="{{url($movie->cover)}}" class="img img-responsive">
    </td>
</tr>
                        <tr>
                            <td>Description</td>
                            <td>{{$movie->description}}</td>
                        </tr>
                        <tr>
                            <td>Release Date</td>
                            <td>{{$movie->release_date}}</td>
                        </tr>
                        <tr>
                            <td>
                                Producer
                            </td>
                            <td>{{$movie->producer}}</td>
                        </tr>
                        <tr>
                            <td>Director</td>
                            <td>{{$movie->director}}</td>
                        </tr>
                        <tr>
                            <td>Age Limit</td>
                            <td>{{$movie->age_limit}}</td>
                        </tr>
                        <tr>
                            <td>Time</td>
                            <td>{{$movie->time}}</td>
                        </tr>
                        <tr>
                            <td>Cost</td>
                            <td>{{$movie->cost}}</td>
                        </tr>
                        <tr>
                            <td>Actors</td>
                            <td>
                                <ul class="list-group">
                                    @foreach($movie->actorlist as $actor)
                                        <li class="list-group-item">{{$actor->name}} <a href="{{route('artist.show', [$actor->id])}}" class="pull-right">View</a></li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
