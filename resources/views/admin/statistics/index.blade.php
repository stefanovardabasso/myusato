@extends('layouts.admin')

@section('title',  __('Statistiche'))

@section('content')
    @include('partials._content-heading', ['title' => __('Statistiche')])

    @include('partials._alerts')
    <div class="row">
        <div class="col-lg-12">
        @foreach($places as $p)
            <div class="row" style="margin-top: 2%; margin-bottom: 2%">
                <div class="col-lg-12">
                    <div style="float: right !important;">
                        <input type="text" id="date_{{$p->id}}" class="form-control" onchange="checkbydate({{$p->id}})"  name="daterange" value="<?php echo config('main.date_of_online'); ?> - <?php echo date('m/d/Y'); ?>" min="<?php echo config('main.date_of_online'); ?>"  max="<?php echo date('m/d/Y'); ?>" />
                    </div>
                <h3>{{$p->name}}</h3>

                    <div class="row" style="margin-bottom: 3%">
                        <div class="col-lg-4">
                            <div class="card" style="border: 1px solid gray; box-shadow: 2px 5px 10px darkgray; border-radius: 6px;; background-color: white">
                                <div class="card-body">
                                    <h5 class="card-title"><center>Macchine opzionate</center></h5>
                                    <h1 style="text-align: center; color: #00a65a" id="option_{{$p->id}}">0</h1>
                                    <canvas id="chart_option_{{$p->id}}" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card" style="border: 1px solid gray; box-shadow: 2px 5px 10px darkgray; border-radius: 6px;; background-color: white">
                                <div class="card-body">
                                    <h5 class="card-title"><center>Vendite concluse</center></h5>
                                    <h1 style="text-align: center; color: #00a65a" id="sell_{{$p->id}}">0</h1>
                                    <canvas id="chart_sell_{{$p->id}}" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card" style="border: 1px solid gray; box-shadow: 2px 5px 10px darkgray; border-radius: 6px;; background-color: white">
                                <div class="card-body">
                                    <h5 class="card-title"><center>Numero di venditori</center></h5>
                                    <h1 style="text-align: center; color: #00a65a" id="vendor_{{$p->id}}">0</h1>
                                    <canvas id="chart_vendor_{{$p->id}}" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
                <hr style="border: 1px solid gray;">
        @endforeach
        </div>
    </div>


    <div class="pull-right" style="margin-top: 5%">
        <a href="{{ URL::previous() }}" class="btn btn-primary">@lang('Back')</a>
    </div>

    <script>

    $(document).ready(function () {

        start();

    });

    // Global scope arrays for Chart.js canvas
    myChartOptions = [];
    myChartSales = [];
    myChartVendors = [];

    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });

    function updateCharts(placeid, dateStart, dateEnd){

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{url('api/checkbydate')}}",
            type: 'post',
            dataType: 'json',
            data: {_token: CSRF_TOKEN, date_start: dateStart, date_end: dateEnd, placeid:placeid},
            success: function (response) {

                var a = response['resp']['options_numb'];
                var b = response['resp']['sales_numb'];
                var c = response['resp']['vendors_numb'];

                document.getElementById('option_'+placeid).innerHTML =  a;
                document.getElementById('sell_'+placeid).innerHTML = b;
                document.getElementById('vendor_'+placeid).innerHTML = c;

                myChartOptions[placeid].data.labels = response['resp']['options_chart_values_x'];
                myChartOptions[placeid].data.datasets.forEach((dataset) => {
                    dataset.data = response['resp']['options_chart_values_y'];
                });
                myChartOptions[placeid].update();

                myChartSales[placeid].data.labels = response['resp']['sales_chart_values_x'];
                myChartSales[placeid].data.datasets.forEach((dataset) => {
                    dataset.data = response['resp']['sales_chart_values_y'];
                });
                myChartSales[placeid].update();

                myChartVendors[placeid].data.labels = response['resp']['vendors_chart_values_x'];
                myChartVendors[placeid].data.datasets.forEach((dataset) => {
                    dataset.data = response['resp']['vendors_chart_values_y'];
                });
                myChartVendors[placeid].update();
            }
        });

    }

    function renderCharts(placeid, dateStart, dateEnd){

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{url('api/checkbydate')}}",
            type: 'post',
            dataType: 'json',
            data: {_token: CSRF_TOKEN, date_start: dateStart, date_end: dateEnd, placeid:placeid},
            success: function (response) {

                var a = response['resp']['options_numb'];
                var b = response['resp']['sales_numb'];
                var c = response['resp']['vendors_numb'];

                document.getElementById('option_'+placeid).innerHTML =  a;
                document.getElementById('sell_'+placeid).innerHTML = b;
                document.getElementById('vendor_'+placeid).innerHTML = c;

                var ctx = document.getElementById('chart_option_'+placeid).getContext('2d');[]
                myChartOptions[placeid] = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: response['resp']['options_chart_values_x'],
                        datasets: [{
                            hidden: false,
                            label: '# macchine opzionate',
                            data: response['resp']['options_chart_values_y'],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                            ],
                            borderWidth: 2,
                            fill: true
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                type: 'linear',
                                min: 0,
                                suggestedMax: 6
                                // max:  response['resp']['options_chart_y_max']
                            }
                        },
                        layout: {
                            padding: {
                                top: 10,
                                right: 50,
                                bottom: 30,
                                left: 20
                            }
                        },
                        animation: {
                            duration: 1200,
                            easing: 'linear',
                            // loop: true
                        },
                        plugins:{
                            legend: {
                                display: false
                            }
                        }
                    }
                });

                var ctx = document.getElementById('chart_sell_'+placeid).getContext('2d');
                myChartSales[placeid] = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: response['resp']['sales_chart_values_x'],
                        datasets: [{
                            hidden: false,
                            label: '# vendite concluse',
                            data: response['resp']['sales_chart_values_y'],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',

                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                            ],
                            fill: true,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                type: 'linear',
                                min: 0,
                                suggestedMax: 6
                                // max:  response['resp']['sales_chart_y_max']
                            }
                        },
                        layout: {
                            padding: {
                                top: 10,
                                right: 50,
                                bottom: 30,
                                left: 20
                            }
                        },
                        animation: {
                            duration: 1200,
                            easing: 'linear',
                            // loop: true
                        },
                        plugins:{
                            legend: {
                                display: false
                            }
                        }
                    }
                });

                var ctx = document.getElementById('chart_vendor_'+placeid).getContext('2d');
                myChartVendors[placeid] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response['resp']['vendors_chart_values_x'],
                        datasets: [{
                            hidden: false,
                            label: '# venditori',
                            data: response['resp']['vendors_chart_values_y'],
                            backgroundColor: [
                                'rgba(255, 206, 86, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 206, 86, 1)',
                            ],
                            fill: true,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                type: 'linear',
                                min: 0,
                                suggestedMax: 6
                                // max:  response['resp']['vendors_chart_y_max']
                            }
                        },
                        layout: {
                            padding: {
                                top: 10,
                                right: 50,
                                bottom: 30,
                                left: 20
                            }
                        },
                        animation: {
                            duration: 1200,
                            easing: 'linear',
                            // loop: true
                        },
                        plugins:{
                            legend: {
                                display: false
                            }
                        }
                    }
                });

            }
        });

    }

    function checkbydate(placeid) {
        var datas = document.getElementById('date_'+placeid).value;
        const myDatasArr = datas.split(" - ");
        const dateArrayConv = [];
        let date_start = new Date(Date.parse(myDatasArr[0]));
        let date_end = new Date(Date.parse(myDatasArr[1]));
        dateArrayConv[0] = new Date (date_start.getTime() - (date_start.getTimezoneOffset() * 60000 )).toISOString().split("T")[0];
        dateArrayConv[1] = new Date (date_end.getTime() - (date_end.getTimezoneOffset() * 60000 )).toISOString().split("T")[0];
        updateCharts(placeid, dateArrayConv[0], dateArrayConv[1])
    }

    function defaultchartdate(placeid) {
        var datas = document.getElementById('date_'+placeid).value;
        const myDatasArr = datas.split(" - ");
        const dateArrayConv = [];
        let date_start = new Date(Date.parse(myDatasArr[0]));
        let date_end = new Date(Date.parse(myDatasArr[1]));
        dateArrayConv[0] = new Date (date_start.getTime() - (date_start.getTimezoneOffset() * 60000 )).toISOString().split("T")[0];
        dateArrayConv[1] = new Date (date_end.getTime() - (date_end.getTimezoneOffset() * 60000 )).toISOString().split("T")[0];

        renderCharts(placeid, dateArrayConv[0], dateArrayConv[1])
    }


    function start() {

        <?php foreach ($places as $p) { ?>

        defaultchartdate({{$p->id}})

    <?php } ?>
    }

    </script>

@stop


