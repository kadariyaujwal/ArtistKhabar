@extends('adminlte::page')

@section('title', 'Veiw Quiz'.$quiz['title'])

@section('content_header')
    <h1>
        View Quiz
        <small>{{$quiz['title']}}</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{route('quiz.index')}}"><i class="fa fa-gamepad"></i> Quiz</a>
        </li>
        <li class="active">View</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Quiz Data ({{$quiz['title']}})</h3>
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
                            @foreach($quiz as $key => $value)
                                @if($key=='parent_key' || $key == 'parent')
                                <tr>
                                    <td>Parent Key</td>
                                    <td>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                {{$value['title']}}
                                                <a href="{{route('quiz.show',[$value['id']])}}" class="pull-right">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @elseif($key=='children')
                                    <tr>
                                        <td>Children Key</td>
                                        <td>
                                            <ul class="list-group">
                                                @foreach($value as $k => $v)
                                                    <li class="list-group-item">
                                                        {{$v['title']}}
                                                        <a href="{{route('quiz.show',[$v['id']])}}" class="pull-right">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @elseif($key == 'picture')
                                    <tr>
                                        <td>Picture</td>
                                        <td>
                                            @if(strlen($value) > 0)
                                                <img src="{{url($value)}}" alt="Image" class="img-responsive img">
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                <tr>
                                    <td>{{$key}}</td>
                                    <td>{{$value}}</td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
