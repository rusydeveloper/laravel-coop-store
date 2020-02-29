@extends('layouts.manager')

@section('content')
<style type="text/css">
    .table {
        width: 100%;
        font-size: 12pt
    }

    .report-container {
        margin-bottom: 50px;
        text-align: center
    }

    .date-information {
        font-size: 12pt
    }
</style>
<div class="container">
    <div class="row justify-content-center report-container">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-shopping-basket"></span> Jumlah Order</div>
                <div class="card-body">
                    <span>{{$invoices->count()}}</span>
                    <p>Pesanan</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-money"></span> Jumlah Transaksi Dibayar Hari Ini</div>
                <div class="card-body">
                    <span>{{number_format($invoices->where('status', 'paid')->sum('amount'),0,",",".")}}</span>
                    <p>Rupiah</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-clone"></span> Rekap Hari Ini
                </div>
                <div class="card-body">
                    <input type="text" class="input-search" id="searchInvoiceCode" onkeyup="searchTenant()"
                        placeholder="Masukan Usaha dan Kode Booking">
                    <table id="tenantTable" class="table table-responsive table-striped table-hover"
                        style="font-size: 10pt">
                        <tr>
                            <td>Nama</td>
                            <td>Jumlah</td>
                            <td>Hasil Tenant (75%)</td>
                            <td>Hasil Nectico (25%)</td>
                        </tr>
                        @foreach ($invoices_groupBy_tenant as $key => $value)
                        <tr>
                            <td>{{ App\User::find($key)->business->first()->name }} ({{ App\User::find($key)->name }})
                            </td>
                            <td style="text-align: right">{{ number_format($value,0,",",".")}}</td>
                            <td style="text-align: right">{{ number_format($value*0.75,0,",",".")}}</td>
                            <td style="text-align: right">{{ number_format($value*0.25,0,",",".")}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>Total</td>
                            <td style="text-align: right">
                                {{number_format($invoices->where('status', 'paid')->sum('amount'),0,",",".")}}</td>
                            <td style="text-align: right">
                                {{number_format($invoices->where('status', 'paid')->sum('amount')*0.75,0,",",".")}}</td>
                            <td style="text-align: right">
                                {{number_format($invoices->where('status', 'paid')->sum('amount')*0.25,0,",",".")}}</td>
                        </tr>


                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-pie-chart"></span> Report
                    <a href="/admin/user/add">
                        <!-- <button class="btn btn-primary btn-md pull-right">+ Tambah</button> -->
                    </a>
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
                                <form method="POST" action="/manager/report/daily" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="report-category">Kategori Laporan</label>
                                        <div class="form-control form-custom">
                                            <div class="form-check-inline">
                                                <label class="form-check-label" for="revenue">
                                                    <input type="radio" class="form-check-input custom-radio"
                                                        id="revenue" name="category" value="revenue" checked><span
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
                                <form method="POST" action="/manager/report/weekly" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="report-category">Kategori Laporan</label>
                                        <div class="form-control form-custom">
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
                                aria-labelledby="pills-contact-tab">
                                <h4 class="payment-type">Laporan Bulanan</h4>
                                <hr>
                                <form method="POST" action="/manager/report/monthly" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="report-category">Kategori Laporan</label>
                                        <div class="form-control form-custom">
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
                            <div class="tab-pane fade" id="pills-periodic" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <h4 class="payment-type">Laporan Periodic</h4>
                                <hr>
                                <form method="POST" action="/manager/report/periodic" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="report-category">Kategori Laporan</label>
                                        <div class="form-control form-custom">

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
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <span class="fa fa-shopping-basket"></span> Pesanan
                        <span class="pull-right date-information" id="live_time"></span>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <input type="text" class="input-search" id="searchInvoiceCode" onkeyup="searchInvoice()"
                            placeholder="Masukan Usaha dan Kode Booking">
                        <table id="invoiceTable" class="table table-striped table-hover" style="font-size: 10pt">
                            <thead>
                                <tr>
                                    <th>Kode Booking</th>
                                    <th>Status</th>
                                    <th>Waktu Pesan</th>
                                    <th>Keterangan</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $item)
                                <tr>
                                    <td>{{$item->booking_id}}</td>
                                    <td>
                                        @if($item->status == 'unpaid')
                                        <span class="badge badge-danger">
                                            {{$item->status}}
                                        </span>
                                        @elseif($item->status == 'paid')
                                        <span class="badge badge-secondary">
                                            {{$item->status}}
                                        </span>
                                        @endif

                                    </td>
                                    <td>{{date('d-M-Y H:i:s', strtotime($item->created_at))}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>Rp {{number_format($item->amount,0,",",".")}}</td>
                                    <td>

                                        <form method="POST" action="/cashier/invoice/show"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                                            <button class="btn btn-md btn-secondary">Rincian</button>
                                        </form>


                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Belum ada pesanan</td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function searchTenant() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("searchTenantName");
      filter = input.value.toUpperCase();
      table = document.getElementById("tenantTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }       
}
}

function searchInvoice() {
    var input, filter, table, tr, td, td2, i, txtValue, txtValue2;
    input = document.getElementById("searchInvoiceCode");
    filter = input.value.toUpperCase();
    table = document.getElementById("invoiceTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        td2 = tr[i].getElementsByTagName("td")[2];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            if (td2) {
              txtValue2 = td2.textContent || td2.innerText;
              if (txtValue2.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}       
}
}
    </script>
    @endsection