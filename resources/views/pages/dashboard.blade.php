@extends('template.master')
@section('title', 'Dashboard')

@section('content')

<div class="row">
    <div class="card w-100">
        <!-- /.col -->
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $buku }}</h3>

                        <p>Banyak Buku</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                    @hasrole('admin')
                        <a href="{{ route('admin.master-buku') }}" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    @else
                        <a href="{{ route('member.list-buku') }}" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    @endhasrole
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-success">
                    <div class="inner">
                        <h3><sup style="font-size: 20px">Rp</sup> {{ $denda }}</h3>
                        
                        @hasrole('admin')
                            <p>Total Denda Member</p>
                        @else
                            <p>Total Denda</p>
                        @endhasrole

                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                        <a href="#" class="small-box-footer pt-4 pb-1r"></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$member}}</h3>

                        <p>Banyak Member</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    @hasrole('admin')
                        <a href="{{route('admin.member')}}" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    @else
                        <a href="#" class="small-box-footer pt-4 pb-1"></a>
                    @endhasrole
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $buku_dipinjamkan }}</h3>

                        @hasrole('admin')
                            <p style="font-size: 15px;">Buku Dipinjamkan</p>
                        @else
                            <p style="font-size: 15px;">Buku Dipinjam</p>
                        @endhasrole
                    </div>
                    <div class="icon">
                        <i class="fas fa-list"></i>
                    </div>
                        @hasrole('member')
                            <a href="{{route('member.list-buku')}}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        @else
                            <a href="#" class="small-box-footer pt-4 pb-1"></a>
                        @endhasrole
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-6">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{ asset('Image/Dashboard/1.jpg') }}" alt="First slide" style="width: 500px;height:300px">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{ asset('Image/Dashboard/2.jpg') }}" alt="Second slide" style="width: 500px;height:300px">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{ asset('Image/Dashboard/3.jpg') }}" alt="Third slide" style="width: 500px;height:300px">
                            </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-custom-icon" aria-hidden="true">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                            <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-custom-icon" aria-hidden="true">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                            <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="card-body">
                            <canvas id="donutChart" class="mb-2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            <center id="caption-chart"></center>
                        </div>
                    </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.row -->

@endsection

@push('script')

<script>
    $(document).ready(function(){
        let chart = @json($chart);
        let banyak_chart = @json($count_chart);
        let label = [];
        let datasetsData = [];
        let randomColor = [];
        const tahun = new Date();
        let bar_chart = @json($aktifitas_peminjaman);

        $('#caption-chart').html(banyak_chart+' Jenis Kategori Terbanyak Digunakan Buku').addClass('font-weight-bold');

        chart.map((val, idx) => {
            label.push(val.nama_kategori);
            datasetsData.push(val.jumlah);
            randomColor.push("#"+ Math.floor(Math.random()*16777215).toString(16));
        });


        //-------------
        //- DONUT CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData        = {
        labels: label,
        datasets: [
            {
            data: datasetsData,
            backgroundColor : randomColor,
            }
        ]
        }
        var donutOptions     = {
        maintainAspectRatio : false,
        responsive : true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
        })


        var areaChartData = {
            labels  : ['Januari', 'Februari', 'Maret', 'April', 'Mey', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            datasets: [
                {
                label               : 'Aktivitas Peminjaman Per Tahun '+ tahun.getFullYear(),
                backgroundColor     : 'rgba(60,141,188,0.9)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : bar_chart,
                },
            ]
        }

         //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp = areaChartData.datasets[0]
        barChartData.datasets[0] = temp

        var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false
        }

        new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
        })
    })
</script>

@endpush