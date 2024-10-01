@extends('layouts.main')

@section('css')
<style type="text/css">
    .chart-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%; /* This ensures the container takes the available height */
    }

    canvas {
        max-width: 100%;
        height: auto; /* This will make sure the chart takes the height dynamically */
    }
</style>
@endsection

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
                                </div><!-- .card-title-group -->
                                <div class="mt-2 mb-4">
                                    <div class="amount h1">{{array_sum($incidentChartData['datasets'][0]['data'])}}</div>
                                </div>
                                <div class="chart-container">
                                    <canvas data-nk-chart="bar" id="sessionChart"></canvas>
                                </div>
                            </div><!-- .card-body -->
                        </div><!-- .card -->
                    </div><!-- .col -->

                    <div class="col-sm-6 col-xl-6 col-xxl-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="card-title-group align-items-start">
                                    <div class="card-title">
                                        <h4 class="title">No. of Incidents (Quarterly)</h4>
                                    </div>
                                </div><!-- .card-title-group -->
                                <div class="mt-2 mb-4">
                                    <div class="amount h1">{{array_sum($incidentByQuarter['datasets'][0]['data'])}}</div>
                                </div>
                                <div class="chart-container">
                                    <canvas data-nk-chart="bar" id="incidentBar"></canvas>
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
                    <div class="col-sm-6 col-xl-6 col-xxl-3">
                        <div class="card card-bordered h-100">
                            <div class="card card-bordered">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Incidents by Status</h5>
                                    <canvas id="incidentStatusChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-gs mt-1">
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
                                                                <p class="small"><strong><a class="link-info" href="/incidents/{{$incident->incident->incident_number}}/show">{{$incident->incident->incident_number}}</a></strong>  - {!! $incident->description !!} by <a href="{{route('users.show', $incident->user->id)}}">{{ $incident->user->name }}</a> - <span style="font-size: 0.7rem; color:darkgrey; font-style:italic">{{$incident->created_at->diffForHumans()}}</span></p>
                                                            @else
                                                            <p class="small"><strong><a class="link-info" href="/incidents/{{$incident->incident->incident_number}}/show">{{$incident->incident->incident_number}}</a></strong>  - {!! $incident->description !!} - <span style="font-size: 0.7rem; color:darkgrey; font-style:italic">{{$incident->created_at->diffForHumans()}}</span></p>
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
                    
                    <div class="col-md-12 col-xxl-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="card-title">
                                    <h5 class="title">Top Contract with Incidents</h5>
                                </div>
                                <div class="nk-tb-list mt-5">
                                    <table class="table table-responsive">
                                        <thead>
                                            <tr class="table-light">
                                                <th class="tb-col"><span class="">Contract</span></th>
                                                <th class="tb-col"><span class="">No. of Incidents</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($contracts as $contract)
                                                <tr>
                                                    <td class="tb-col">
                                                        {!! $contract['contract_name'] !!}
                                                    </td>
                                                    <td class="tb-col">
                                                        <span class="tb-tnx-id">{{$contract['total_incidents']}}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div><!-- .nk-tb-list -->
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

    var incidentBarBE = {
        labels : @json($incidentByQuarter['labels']),
        datasets : @json($incidentByQuarter['datasets'])
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

    let setDataBar = {
        labels : incidentBarBE.labels,
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
                data: incidentBarBE.datasets[0].data
            },
        ]
    };

    console.log(sessionChart);

    // Global variable to hold chart instance
    var sessionChart;
    var incidentBar;

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
                maintainAspectRatio:true,
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

        // Incident Bar Chart
        let chartDataBar = [];

        for (let i = 0; i < setDataBar.datasets.length; i++) {
            chartDataBar.push({
                label: setDataBar.datasets[i].label,
                backgroundColor: (typeof setDataBar.datasets[i].background === 'undefined') ? 'transparent' : setDataBar.datasets[i].background,
                borderWidth: (typeof setDataBar.datasets[i].border === 'undefined') ? 1 : setDataBar.datasets[i].border,
                borderColor: setDataBar.datasets[i].color,
                data: setDataBar.datasets[i].data,
                borderRadius: (typeof setDataBar.datasets[i].borderRadius === 'undefined') ? 0 : setDataBar.datasets[i].borderRadius,
                borderSkipped: false,
                hoverBackgroundColor: setDataBar.datasets[i].hoverBackgroundColor
            });
        }

        let canvasBar = document.getElementById('incidentBar').getContext("2d");
        incidentBar = new Chart(canvasBar, {
            type:'bar',
            data:{ 
                labels : setDataBar.labels,
                datasets : chartDataBar
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
                maintainAspectRatio:true,
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

        // Incident Status Pie Chart
        // Get the incident status data from the controller (passed from PHP)
        let incidentStatus = @json($incidentStatus);

        // Convert the data to an array for Chart.js
        let statuses = Object.keys(incidentStatus);

        // change value to proper string
        statuses = statuses.map(function(status) {
            if (status == 'open') {
                return ' Open';
            } else if (status == 'closed') {
                return ' Closed';
            } else if (status == 'resolved') {
                return ' Resolved';
            } else if (status == 'in_progress') {
                return ' In Progress';
            } else if (status == 'verified') {
                return ' Verified';
            } else {
                return ' Unasigned';
            }
        });

        let statusCounts = Object.values(incidentStatus);

        console.log(statuses);
        console.log(statusCounts);

        // Create the pie chart
        var ctx = document.getElementById('incidentStatusChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: statuses, // e.g., ['High', 'Medium', 'Low']
                datasets: [{
                    data: statusCounts, // e.g., [5, 10, 15]
                    backgroundColor: [NioApp.Colors.light, NioApp.Colors.info, NioApp.Colors.warning, NioApp.Colors.success], // Colors for each slice
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