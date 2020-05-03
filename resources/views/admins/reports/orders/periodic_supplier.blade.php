@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p>Laporan Penjualan Periode {{date('d M Y', strtotime($date_report_start))}} s.d
                        {{date('d M Y', strtotime($date_report_end))}}</p>
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
                    <p>Pengelompokan per supplier yang <b>sudah dibayar</b></p>
                    <table class="table table-striped table-hover" style="font-size: 10pt">
                        <thead>
                            <tr class="text-center">
                                <th>Koperasi Pemesan</th>
                                <th>Kuantitas Produk Dipesan</th>
                                <th>Total Transaksi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders_groupBy_supplier as $item)
                            <tr>
                                <td>{{App\Business::find($item->business_id)->name}}</td>
                                <td style="text-align: center">
                                    {{number_format($item->quantity,0,",",".")}}</td>
                                <td style="text-align: right">Rp {{number_format($item->sum,0,",",".")}}</td>
                                <td style="text-align: center">
                                    <form method="POST" action="/admin/report/order/periodic/supplier/cooperative"
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="date_report_start" value="{{$date_report_start}}">
                                        <input type="hidden" name="date_report_end" value="{{$date_report_end}}">
                                        <input type="hidden" name="supplier_id" value="{{$supplier_id}}">
                                        <input type="hidden" name="business_id" value="{{$item->business_id}}">
                                        <button class="btn btn-warning btn-sm btn-space">Rincian</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">Data Kosong</td>

                            </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection