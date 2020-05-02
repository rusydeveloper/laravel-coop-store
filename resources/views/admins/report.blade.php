@extends('layouts.admin')
@section('content')
<style type="text/css">
    .nav-pills {
        font-size: 15pt
    }

    .tab-content {
        font-size: 14pt
    }

    .form-custom {
        font-size: 16pt
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-pie-chart"></span> Report

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
                                <a class="nav-link" id="pills-weekly-tab" data-toggle="pill" href="#pills-weekly"
                                    role="tab" aria-controls="pills-weekly" aria-selected="false">Mingguan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-monthly-tab" data-toggle="pill" href="#pills-monthly"
                                    role="tab" aria-controls="pills-contact" aria-selected="false">Bulanan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-yearly-tab" data-toggle="pill" href="#pills-yearly"
                                    role="tab" aria-controls="pills-contact" aria-selected="false">Tahunan</a>
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
                                <form method="POST" action="/admin/report/daily" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="report-category">Kategori Laporan</label>
                                        <div class="form-control form-custom">
                                            <div class="form-check-inline">
                                                <label class="form-check-label" for="order">
                                                    <input type="radio" class="form-check-input custom-radio" id="order"
                                                        name="category" value="order" checked><span
                                                        class="fa fa-shopping-basket"></span> Order
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label" for="revenue">
                                                    <input type="radio" class="form-check-input custom-radio"
                                                        id="revenue" name="category" value="revenue"><span
                                                        class="fa fa-line-chart"></span> Revenue
                                                </label>
                                            </div>
                                        </div>
                                    </div>
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
                            <div class="tab-pane fade" id="pills-weekly" role="tabpanel"
                                aria-labelledby="pills-weekly-tab">
                                <h4 class="payment-type">Laporan Mingguan</h4>
                                <hr>
                                <form method="POST" action="/admin/report/weekly" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="report-category">Kategori Laporan</label>
                                        <div class="form-control form-custom">
                                            <div class="form-check-inline">
                                                <label class="form-check-label" for="order">
                                                    <input type="radio" class="form-check-input custom-radio" id="order"
                                                        name="category" value="order" checked><span
                                                        class="fa fa-shopping-basket"></span> Pesanan
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label" for="revenue">
                                                    <input type="radio" class="form-check-input custom-radio"
                                                        id="revenue" name="category" value="revenue"><span
                                                        class="fa fa-line-chart"></span> Pemasukan
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="date_report">Pilih Tanggal Minggu</label>
                                        <input type="date" class="form-control" id="date_report" name="date_report"
                                            min="0">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-pay">Lihat Laporan</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-monthly" role="tabpanel"
                                aria-labelledby="pills-monthly-tab">
                                <h4 class="payment-type">Laporan Bulanan</h4>
                                <hr>
                                <form method="POST" action="/admin/report/monthly" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="report-category">Kategori Laporan</label>
                                        <div class="form-control form-custom">
                                            <div class="form-check-inline">
                                                <label class="form-check-label" for="order">
                                                    <input type="radio" class="form-check-input custom-radio" id="order"
                                                        name="category" value="order" checked>
                                                    <span class="fa fa-shopping-basket"></span> Order
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label" for="revenue">
                                                    <input type="radio" class="form-check-input custom-radio"
                                                        id="revenue" name="category" value="revenue"><span
                                                        class="fa fa-line-chart"></span> Revenue
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="year_report">Pilih Tahun</label>
                                        <select class="form-control" id="report-weekly" name="year_report">
                                            <?php
                                            $year_start = 2018;
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
                            <div class="tab-pane fade" id="pills-yearly" role="tabpanel"
                                aria-labelledby="pills-yearly-tab">
                                <h4 class="payment-type">Laporan Tahunan</h4>
                                <hr>
                                <form method="POST" action="/admin/report/yearly" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="report-category">Kategori Laporan</label>
                                        <div class="form-control form-custom">
                                            <div class="form-check-inline">
                                                <label class="form-check-label" for="order">
                                                    <input type="radio" class="form-check-input custom-radio" id="order"
                                                        name="category" value="order" checked>
                                                    <span class="fa fa-shopping-basket"></span> Order
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label" for="revenue">
                                                    <input type="radio" class="form-check-input custom-radio"
                                                        id="revenue" name="category" value="revenue"><span
                                                        class="fa fa-line-chart"></span> Revenue
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="year_report">Pilih Tahun</label>
                                        <select class="form-control" id="report-weekly" name="year_report">
                                            <?php
                                            $year_start = 2018;
                                            $year_current = (int)date("Y");
                                            for($x = $year_start; $x <= $year_current; $x++){
                                                echo '<option value="'.$x.'">'.$x.'</option>';
                                            };
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-pay">Lihat Laporan</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-periodic" role="tabpanel"
                                aria-labelledby="pills-periodic-tab">
                                <h4 class="payment-type">Laporan Periodic</h4>
                                <hr>
                                <form method="POST" action="/admin/report/periodic" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="report-category">Kategori Laporan</label>
                                        <div class="form-control form-custom">
                                            <div class="form-check-inline">
                                                <label class="form-check-label" for="order">
                                                    <input type="radio" class="form-check-input custom-radio" id="order"
                                                        name="category" value="order" checked><span
                                                        class="fa fa-shopping-basket"></span> Order
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label" for="revenue">
                                                    <input type="radio" class="form-check-input custom-radio"
                                                        id="revenue" name="category" value="revenue"><span
                                                        class="fa fa-line-chart"></span> Revenue
                                                </label>
                                            </div>
                                        </div>
                                    </div>
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
    @endsection