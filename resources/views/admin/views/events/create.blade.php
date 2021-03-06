@extends('adminlte::page')

@section('content')
<div class="row">
    <div class="col-md-8">
            <div class="box">
                    <div class="box-header bg-blue">
                        <h3 class="box-title">Create New Event</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{route('events.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Title *</label>
                                <input type="text" class="form-control" placeholder="Title..." name="title">
                            </div>
                            <div class="form-group">
                                <label for="description">Description *</label>
                                <textarea placeholder="Description..." class="form-control" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="location">Location *</label>
                                <input type="text" placeholder="Location..." class="form-control" name="location">
                            </div>
                            <div class="form-group">
                                <label for="date">Date *</label>
                                <input type="text" name="date" class="form-control datepicker" placeholder="Select date for event"
                                    required="required">
                            </div>
                            <div class="form-group">
                                <label for="lfm">Select cover picture *</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" readonly="readonly" class="form-control" type="text" name="main_picture"
                                        required="required">
                                </div>
                                <div id="holder"></div>
                            </div>
                            <div class="form-group">
                                <label for="artists[]">Artists *</label>
                                <select name="artists[]" class="select2 form-control" multiple required placeholder="Select artsists">
                                    @foreach($artists as $artist)
                                    <option value="{{$artist->id}}" class="form-control">{{$artist->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lfm1">Select other pictures </label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail1" readonly="readonly" class="form-control" type="text" name="pictures" multiple="multiple">
                                </div>
                                <div id="holder1"></div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" type="submit">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
@stop

@section('js')
<script>
    $(function () {
        $(".select2").select2();
    })
</script>
<script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script>
    $(function () {
        $('#lfm').filemanager('image');
        $('#lfm1').filemanager('image');
    })
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script>
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        orientation: 'bottom',
        todayHighlight: 'TRUE',
        autoclose: true
    });
</script>

@stop
