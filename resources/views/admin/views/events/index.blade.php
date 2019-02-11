@extends('adminlte::page')

@section('content')
<div class="box">
    <div class="box-header bg-blue">
        <h3 class="box-title">
            Manage Events
        </h3>
    </div>
    <div class="box-body">
        <table id="eventsList" class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Photo</th>
                    <th>Location</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
    $(function () {
        $('#eventsList').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route("events.list")}}',
            columns: [{
                    data: 'id',
                    name: 'id',
                },
                {
                    data:'photo',
                    render:function(data){
                        return `<img src="${data}" class="img img-responsive img-circle">`;
                    }
                },
                {
                    data: 'location',
                    name: 'location'
                },
                {
                    data: 'title',
                    name: 'title',
                    render:function(data){
                        if(data.length>=50) return data.substr(0,50);
                        else return data;
                    }
                },
                {
                    data: 'description',
                    name: 'description',
                    render:function(data){
                        if(data.length>=50) return data.substr(0,50)
                        else return data;
                    }
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        var txt = document.createElement('textarea');
                        txt.innerHTML = data;
                        return txt.value;
                    }
                },
                
            ]
        });
        $('#eventsList').on('click','.delete',function(e){
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
                        console.log(data);
                    });
                }else
                    alert("You have cancelled!");
        })
    })

</script>
@stop
