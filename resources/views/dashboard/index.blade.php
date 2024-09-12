@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="row g-gs">
                    <div class="col-sm-6 col-xl-6 col-xxl-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="card-title-group align-items-start">
                                    <div class="card-title">
                                        <h4 class="title">Incidents Created</h4>
                                    </div>
                                    <div class="media media-middle media-circle media-sm text-bg-primary-soft">
                                        <em class="icon icon-md ni ni-user-alt-fill"></em>
                                    </div>
                                </div><!-- .card-title-group -->
                                <div class="mt-2 mb-4">
                                    <div class="amount h1">{{array_sum($incidentChartData['datasets'][0]['data'])}}</div>
                                </div>
                                <div class="nk-chart-analytics-session">
                                    <canvas data-nk-chart="bar" id="sessionChart"></canvas>
                                </div>
                            </div><!-- .card-body -->
                        </div><!-- .card -->
                    </div><!-- .col -->

                    <div class="col-sm-6 col-xl-6 col-xxl-3">
                        <div class="card card-bordered h-100">
                            <div class="card card-bordered">
                                <div class="card-body">
                                    <h5 class="card-title">Incidents by Priority</h5>
                                    <canvas id="incidentPriorityChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card for Incident Priority Pie Chart -->
                </div>

                <div class="row g-gs mt-3">
                    <div class="col-md-12 col-xxl-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h5 class="title">Recent Activity</h5>
                                    </div>
                                </div><!-- .card-title-group -->
                                <div class="nk-timeline nk-timeline-center mt-4">
                                    <div class="nk-timeline-group">
                                        <div class="nk-timeline-heading">
                                            <h6 class="overline-title">Incidents</h6>
                                        </div>
                                        <ul class="nk-timeline-list">
                                            @foreach($recentIncidents as $incident)
                                                <li class="nk-timeline-item">
                                                    <div class="nk-timeline-item-inner">
                                                        <div class="nk-timeline-symbol">
                                                            @if(str_contains($incident->description, 'Changed'))
                                                                <div class="media media-md media-middle media-circle text-bg-success">
                                                                    <em class="icon ni ni-arrow-right"></em>
                                                                </div>
                                                            @elseif(str_contains($incident->description, 'Created'))
                                                                <div class="media media-md media-middle media-circle text-bg-info">
                                                                    <em class="icon ni ni-user"></em>
                                                                </div>
                                                            @elseif(str_contains($incident->description, 'Deleted'))
                                                                <div class="media media-md media-middle media-circle text-bg-danger">
                                                                    <em class="icon ni ni-trash"></em>
                                                                </div>
                                                            @elseif(str_contains($incident->description, 'Incident assigned'))
                                                                <div class="media media-md media-middle media-circle text-bg-warning">
                                                                    <em class="icon ni ni-user"></em>
                                                                </div>
                                                            @elseif(str_contains($incident->description, 'Comment added'))
                                                                <div class="media media-md media-middle media-circle text-bg-warning">
                                                                    <em class="icon ni ni-note-add"></em>
                                                                </div>
                                                            @else
                                                                <div class="media media-md media-middle media-circle text-bg-warning">
                                                                    <em class="icon ni ni-arrow-right"></em>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="nk-timeline-content">
                                                            @if(str_contains($incident->description, 'Comment added'))
                                                                <p class="small"><strong>{{$incident->incident->incident_number}}</strong>  - {!! $incident->description !!} by <a href="{{route('users.show', $incident->user->id)}}">{{ $incident->user->name }}</a> - <span style="font-size: 0.7rem; color:darkgrey; font-style:italic">{{$incident->created_at->diffForHumans()}}</span></p>
                                                            @else
                                                            <p class="small"><strong>{{$incident->incident->incident_number}}</strong>  - {!! $incident->description !!} - <span style="font-size: 0.7rem; color:darkgrey; font-style:italic">{{$incident->created_at->diffForHumans()}}</span></p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div><!-- .nk-timeline -->
                            </div><!-- .card-body -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                    
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="/assets/js/charts/analytics-chart.js"></script>

<script>
    var sessionChartBE = {
        labels : @json($incidentChartData['labels']),
        datasets : @json($incidentChartData['datasets'])
    };

    let setData = {
        labels : sessionChartBE.labels,
        legend: false,
        xAxis:  false,
        barThickness: 6,
        ticksColor: '#787c9e',
        ticksFontSize: 11,
        ticksFontWeight: 300,
        gridBorderDash: [8, 4],
        gridColorX: NioApp.Colors.gray100,
        gridColorY: NioApp.Colors.gray100,
        gridBorderColorX: NioApp.Colors.gray100,
        gridBorderColorY: NioApp.Colors.gray100,
        datasets: [
            {
                borderRadius: 2,
                borderWidth: 1,
                color: NioApp.Colors.primary,
                background: NioApp.Colors.primary,
                label: " Incident(s)",
                data: sessionChartBE.datasets[0].data
            },
        ]
    };

    console.log(sessionChart);

    // Global variable to hold chart instance
    var sessionChart;

    document.addEventListener('DOMContentLoaded', function () {
        let chartLegend = false;   
        let chartStacked = false;
        let chartxAxis = true;
        let chartyAxis = true;
        let chartTicksColor = setData.ticksColor;
        let chartTicksFontSize = setData.ticksFontSize;
        let chartTicksFontWeight = setData.ticksFontWeight;
        let chartMaxTicksLimit = setData.maxTicksLimit;
        let chartTicksValue = false;

        let chartGridColorX = setData.gridColorX;
        let chartGridColorY = setData.gridColorY;
        let chartGridBorderColorX = setData.gridBorderColorX;
        let chartGridBorderColorY = setData.gridBorderColorY;
        let chartGridBorderDash = setData.gridBorderDash;

        let chartBarPercentage = 0.1;
        let chartCategoryPercentage = 0.1;
        let chartBarThickness = setData.barThickness;

        let chartData = [];
                

        for (let i = 0; i < setData.datasets.length; i++) {
            chartData.push({
                label: setData.datasets[i].label,
                backgroundColor: (typeof setData.datasets[i].background === 'undefined') ? 'transparent' : setData.datasets[i].background,
                borderWidth: (typeof setData.datasets[i].border === 'undefined') ? 1 : setData.datasets[i].border,
                borderColor: setData.datasets[i].color,
                data: setData.datasets[i].data,
                borderRadius: (typeof setData.datasets[i].borderRadius === 'undefined') ? 0 : setData.datasets[i].borderRadius,
                borderSkipped: false,
                hoverBackgroundColor: setData.datasets[i].hoverBackgroundColor
            });
        }

        let canvas = document.getElementById('sessionChart').getContext("2d");
        sessionChart = new Chart(canvas, {
            type:'bar',
            data:{ 
                labels : setData.labels,
                datasets : chartData
            },
            options: {
                plugins: {
                    legend: {
                        display: chartLegend,
                        ...NioApp.Chart.legend,
                    },
                    tooltip: {
                        enabled:true,
                        ...NioApp.Chart.tooltip,
                    },
                },
                responsive: true,
                maintainAspectRatio:false,
                scales: {
                    x: {
                        stacked: chartStacked,
                        display: chartxAxis,
                        grid: {
                            color: chartGridColorX,
                            borderColor: chartGridBorderColorX,
                            borderDash: chartGridBorderDash,
                        },
                        ticks: { 
                            color: chartTicksColor, 
                            beginAtZero: true,
                            maxTicksLimit: chartMaxTicksLimit,
                            font: {
                                size: chartTicksFontSize,
                                weight: chartTicksFontWeight
                            }
                        }
                    },
                    y: {
                        stacked: chartStacked,
                        display: chartyAxis,
                        grid: {
                            color: chartGridColorY,
                            borderColor: chartGridBorderColorY,
                            borderDash: chartGridBorderDash,
                        },
                        ticks: { 
                            // Include a ticks value in the ticks
                            callback: function(value, index, ticks) {
                                return value + chartTicksValue;
                            },
                            color: chartTicksColor, 
                            beginAtZero: true,
                            maxTicksLimit: chartMaxTicksLimit,
                            font: {
                                size: chartTicksFontSize,
                                weight: chartTicksFontWeight
                            }
                        }
                    }
                }
            }
        });

        // Incident Priority Pie Chart
        // Get the incident priority data from the controller (passed from PHP)
        let incidentPriority = @json($incidentPriority);

        // Convert the data to an array for Chart.js
        let priorities = Object.keys(incidentPriority);

        // change value to proper string
        priorities = priorities.map(function(priority) {
            if (priority == ' low') {
                return ' Low';
            } else if (priority == 'medium') {
                return ' Medium';
            } else if (priority == 'high') {
                return ' High';
            } else if (priority == 'critical') {
                return ' Critical';
            } else {
                return ' Unasigned';
            }
        });

        let counts = Object.values(incidentPriority);

        console.log(priorities);
        console.log(counts);

        // Create the pie chart
        var ctx = document.getElementById('incidentPriorityChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: priorities, // e.g., ['High', 'Medium', 'Low']
                datasets: [{
                    data: counts, // e.g., [5, 10, 15]
                    backgroundColor: [NioApp.Colors.danger, NioApp.Colors.warning, NioApp.Colors.purple, NioApp.Colors.info, NioApp.Colors.light], // Colors for each slice
                    // backgroundColor: ['#df3c4e', '#f2bc16', '#f24a8b', '#478ffc', '#E5E7EB'], // Colors for each slice
                    // hoverBackgroundColor: ['#df3c4e', '#f2bc16', '#f24a8b', '#478ffc', '#E5E7EB']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: ''
                    }
                }
            }
        });
    });
</script>
@endsection