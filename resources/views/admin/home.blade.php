@extends('layouts.admin')

@section('title', __('Dashboard'))

@section('content')
    @include('partials._content-heading', ['title' => __('Dashboard')])

    <div class="row">
        <section class="col-lg-12">
            @include('widgets.notifications')
        </section>
    </div>

    <div class="row">
        <section class="col-lg-7 connectedSortable" id="sortable-1">
            @if(isset($widgetsOrder['sortable-1']))
                @foreach($widgetsOrder['sortable-1'] as $widget)
                    @includeIf($widget['id'], ['expanded' => $widget['expanded']])
                @endforeach
            @endif
        </section>

        <section class="col-lg-5 connectedSortable" id="sortable-2">
            @if(isset($widgetsOrder['sortable-2']))
                @foreach($widgetsOrder['sortable-2'] as $widget)
                    @includeIf($widget['id'], ['expanded' => $widget['expanded']])
                @endforeach
            @endif
        </section>

        <section class="col-lg-12 connectedSortable" id="sortable-3">
            @if(isset($widgetsOrder['sortable-3']))
                @foreach($widgetsOrder['sortable-3'] as $widget)
                    @includeIf($widget['id'], ['expanded' => $widget['expanded']])
                @endforeach
            @endif
        </section>

    </div>

@stop

@section('javascript')
    @parent
    <script>
        $(document).ready(function(){
            var sortable = $(".connectedSortable");
            //Make the dashboard widgets sortable Using jquery UI
            sortable.sortable({
                placeholder: "sort-highlight",
                connectWith: ".connectedSortable",
                handle: ".box-header",
                forcePlaceholderSize: true,
                zIndex: 999999,
                stop: function (event, ui) {
                    var data = handleNewWidgetsOrder(sortable);
                    updateWidgetOrder(data);
                }
            });

            $('.connectedSortable .widget').on('expanded.boxwidget', function (evt) {
                var data = handleNewWidgetsOrder(sortable);
                updateWidgetOrder(data);
            });

            $('.connectedSortable .widget').on('collapsed.boxwidget', function () {
                var data = handleNewWidgetsOrder(sortable);
                updateWidgetOrder(data);
            });


            function handleNewWidgetsOrder(sortableContainers) {
                var data = {};

                sortableContainers.each(function () {
                    var widgets = $(this).find('.widget');
                    var tmp = [];
                    widgets.each(function () {
                        var id = $(this).attr('id');
                        var obj = {
                            id: id,
                        };
                        if($(this).hasClass('collapsed-box')) {
                            obj.expanded = 0;
                        }else{
                            obj.expanded = 1;
                        }
                        tmp.push(obj);
                    });
                    data[$(this).attr('id')] = tmp;
                });

                return data;
            }

            function updateWidgetOrder(data) {
                $.ajax({
                    url: "{{ route('admin.ajax.profile.dashboard-order') }}",
                    method: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        widgets: data,
                    },
                    success: function(res) {

                    },
                    error: function (err) {

                    }
                })
            }
        });
    </script>
@stop


