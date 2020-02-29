@extends('layouts.tenant')

@section('content')
<style type="text/css">
    .nav-pills {
        font-size: 12pt
    }

    .tab-content {
        font-size: 11pt
    }

    .form-custom {
        font-size: 13pt
    }
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['imagesparkline']});
</script>

<div class="container">
    <div class="row justify-content-center report-container">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-shopping-basket"></span> Jumlah Penjualan Hari Ini,
                    {{date('d M Y', strtotime($date_report))}}</div>
                <div class="card-body">
                    {{number_format($invoices->where('status', 'paid')->sum('amount'),0,",",".")}}

                    <p>Order</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-money"></span> Jumlah Transaksi Bersih Hari Ini,
                    {{date('d M Y', strtotime($date_report))}}</div>
                <div class="card-body">
                    {{number_format($invoices->where('status', 'paid')->sum('amount')*0.75,0,",",".")}}
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-pie-chart"></span> Laporan

                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @elseif (session('danger'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('danger') }}
                    </div>
                    @endif
                    <div class="payment-form">
                        <h5>Tipe Laporan</h5>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-daily-tab" data-toggle="pill" href="#pills-daily"
                                    role="tab" aria-controls="pills-daily" aria-selected="true">Harian</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="pills-monthly-tab" data-toggle="pill" href="#pills-monthly"
                                    role="tab" aria-controls="pills-contact" aria-selected="false">Bulanan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-periodic-tab" data-toggle="pill" href="#pills-periodic"
                                    role="tab" aria-controls="pills-contact" aria-selected="false">Periodic</a>
                            </li>
                        </ul>
                        <hr>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-daily" role="tabpanel"
                                aria-labelledby="pills-daily-tab">
                                <h4 class="payment-type">Laporan Harian</h4>
                                <hr>
                                <form method="POST" action="/tenant/report/daily" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" class="form-check-input custom-radio" id="revenue"
                                        name="category" value="revenue">
                                    <div class="form-group">
                                        <label for="date_report">Tanggal Laporan</label>
                                        <input type="date" class="form-control" id="date_report" name="date_report"
                                            min="0">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-pay">Lihat Laporan</button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="pills-monthly" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <h4 class="payment-type">Laporan Bulanan</h4>
                                <hr>
                                <form method="POST" action="/tenant/report/monthly" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" class="form-check-input custom-radio" id="revenue"
                                        name="category" value="revenue">
                                    <div class="form-group">
                                        <label for="year_report">Pilih Tahun</label>
                                        <select class="form-control" id="year_report" name="year_report">
                                            <?php
                                    $year_start = 2019;
                                    $year_current = (int)date("Y");
                                    for($x = $year_start; $x <= $year_current; $x++){
                                        echo '<option value="'.$x.'">'.$x.'</option>';
                                    };
                                    ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="month_report">Pilih Bulan</label>
                                        <select class="form-control" id="month_report" name="month_report">
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-pay">Lihat Laporan</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-periodic" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <h4 class="payment-type">Laporan Periodik</h4>
                                <hr>
                                <form method="POST" action="/tenant/report/periodic" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" class="form-check-input custom-radio" id="revenue"
                                        name="category" value="revenue">
                                    <div class="form-group">
                                        <label for="date_report_start">Pilih Tanggal Awal</label>
                                        <input type="date" class="form-control" id="date_report_start"
                                            name="date_report_start">
                                    </div>
                                    <div class="form-group">
                                        <label for="date_report_end">Pilih Tanggal Akhir</label>
                                        <input type="date" class="form-control" id="date_report_end"
                                            name="date_report_end">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-pay">Lihat Laporan</button>
                                    </div>
                                </form>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Grafik Perkembangan Usaha <br />30 Hari Penjualan Terakhir
                </div>
                <div class="card-body">
                    <div id="chart_div" style="width: 230px; height: 100px;"></div>
                </div>
            </div>

            <script>
                google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data_content = [
                                ['Penjualan 30 Hari Terakhir'],
                                            @foreach ($subgroup as $key => $item)
                                                [ {{ $item }} ], 
                                            @endforeach
                                            ];
                        var data = google.visualization.arrayToDataTable(data_content);
    
                        var chart = new google.visualization.ImageSparkLine(document.getElementById('chart_div'));
    
                        chart.draw(data, { showAxisLines: false,  showValueLabels: false, labelPosition: 'bottom'});
                        }
            </script>
        </div>
    </div>
    @endsection