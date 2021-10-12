@extends('layouts.admin')

@section('title', App\Models\Admin\Offert::getTitleTrans())

@section('content')

    @include('partials._content-heading', ['title' => __('Gallery')])

    @include('partials._alerts')


    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row" style="margin-bottom: 5%">
                <div class="col-lg-4">
                    <div id="submit-container">
{{--                        <input type='button' class="btn-submit btn btn-primary" value='Salva' id='submit' />--}}
                        <input type='button' class="btn-submit btn btn-primary" value='Salva e torna indietro' id='submit2' />
                    </div>
                </div>
            </div>




            <ul id="image-list">
            @foreach($images as $im)

                    <div class="col-sm-6 col-md-4" style="width: 200px" id="img{{$im->id}}"  >
                        <div class="thumbnail">
                            <li style="color: transparent;" class="lis"  id="image_{{$im->id}}">
                                <button onclick="deleteimage({{$im->id}})" class="delete-file"   style="background: rgb(255, 4, 4);padding: 0.09rem 0.25em 0px;text-align: center;
                               border-radius: 50%;z-index: 199;color: rgb(255, 255, 255);"><i class="glyphicon glyphicon-remove"></i></button>
                            <img style="width: 150px; height: 150px;" class="img-responsive" alt="{{$im->name}}" src="{{url('upload/'.$im->name)}}">
                            </li>
                        </div>
                    </div>

            @endforeach
            </ul>

        </div>
    </div>

    <script>
        function deleteimage(id) {
            var idimage = id;
            $("#img"+idimage).remove();
            $.ajax({
                url: "{{ url('api/deleteimage') }}?id="+idimage,
                type: 'get',
                success: function(response){

                }

            });
        }

        $(document).ready(function () {




            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var dropIndex;
            $("#image-list").sortable({
                update: function(event, ui) {
                    dropIndex = ui.item.index();
                }
            });

            $('#submit').click(function (e) {
                var imageIdsArray = [];
                $('#image-list li').each(function (index) {

                    var id = $(this).attr('id');
                    var split_id = id.split("_");
                    imageIdsArray.push(split_id[1]);

                });

                $.ajax({
                    url: "{{route('admin.offert.setordersgalleries',['offertid'=> $offert, 'target'=>$target])}}",
                    type: 'get',
                    data: {_token: CSRF_TOKEN,imageIds: imageIdsArray},
                    success: function (response) {
                        $("#txtresponse").css('display', 'inline-block');
                        $("#txtresponse").text(response);
                    }
                });
                e.preventDefault();
            });

            $('#submit2').click(function (e) {
                var imageIdsArray = [];
                $('#image-list li').each(function (index) {

                    var id = $(this).attr('id');
                    var split_id = id.split("_");
                    imageIdsArray.push(split_id[1]);

                });

                $.ajax({
                    url: "{{route('admin.offert.setordersgalleries',['offertid'=> $offert, 'target'=>$target])}}",
                    type: 'get',
                    data: {_token: CSRF_TOKEN,imageIds: imageIdsArray},
                    success: function (response) {
                        window.location= "{{route('admin.offerts.edit',['offert'=> $offert])}}";
                        $("#txtresponse").css('display', 'inline-block');
                        $("#txtresponse").text(response);
                    }
                });
                e.preventDefault();
            });


        });

    </script>
@stop


