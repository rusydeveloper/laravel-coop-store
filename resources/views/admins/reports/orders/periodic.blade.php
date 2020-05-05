@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p>Laporan Penjualan Periode {{date('d M Y', strtotime($date_report_start))}} s.d
                        {{date('d M Y', strtotime($date_report_end))}}</p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center text-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Jumlah Penjualan
                </div>
                <div class="card-body">
                    {{number_format($orders->where('status', 'paid')->sum('price'),0,",",".")}}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Jumlah Pemasukan
                </div>
                <div class="card-body">
                    {{number_format($orders->where('status', 'paid')->sum('price')*0.25,0,",",".")}}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Jumlah Produk Terjual
                </div>
                <div class="card-body">
                    {{number_format($orders->where('status', 'paid')->sum('quantity'),0,",",".")}}
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-shopping-basket"></span>Laporan Order
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
                    <p>Pengelompokan per koperasi yang <b>sudah dibayar</b></p>
                    <table class="table table-striped table-hover" style="font-size: 10pt">
                        <thead>
                            <tr class="text-center">
                                <th>Koperasi</th>
                                <th>Kuantitas Produk Dipesan</th>
                                <th>Total Transaksi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders_groupBy_business as $item)
                            <tr>
                                <td>{{App\Business::find($item->business_id)->name}}</td>
                                <td style="text-align: center">
                                    {{number_format($item->quantity,0,",",".")}}</td>
                                <td style="text-align: right">Rp {{number_format($item->sum,0,",",".")}}</td>
                                <td style="text-align: center">
                                    <form method="POST" action="/admin/report/order/periodic/cooperative"
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="date_report_start" value="{{$date_report_start}}">
                                        <input type="hidden" name="date_report_end" value="{{$date_report_end}}">
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
                                <th>Supplier</th>
                                <th>Kuantitas Produk Dipesan</th>
                                <th>Total Transaksi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders_groupBy_supplier as $item)
                            <tr>
                                <td>{{App\Business::find($item->supplier_id)->name}}</td>
                                <td style="text-align: center">
                                    {{number_format($item->quantity,0,",",".")}}</td>
                                <td style="text-align: right">Rp {{number_format($item->sum,0,",",".")}}</td>
                                <td style="text-align: center">
                                    <form method="POST" action="/admin/report/order/periodic/supplier"
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="date_report_start" value="{{$date_report_start}}">
                                        <input type="hidden" name="date_report_end" value="{{$date_report_end}}">
                                        <input type="hidden" name="business_id" value="{{$item->supplier_id}}">
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
                    <table class="table table-striped table-hover" style="font-size: 10pt">
                        <thead>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Pemilik</th>
                                <th>Harga Satuan</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders_groupBy_product as $item)
                            <tr>
                                <td>{{App\Product::find($item->product_id)->name}}</td>
                                <td>{{App\Product::find($item->product_id)->business["name"]}} -
                                    {{App\Product::find($item->product_id)->user["name"]}}</td>

                                <td style="text-align: right">
                                    {{number_format(App\Product::find($item->product_id)->price,0,",",".")}}</td>
                                <td style="text-align: right">{{number_format($item->quantity,0,",",".")}}</td>
                                <td style="text-align: right">{{number_format($item->sum,0,",",".")}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td>Data Kosong</td>
                                <td></td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>

                <div class="card-body">

                    <table class="table table-striped table-hover" style="font-size: 10pt">
                        <thead>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Created At</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $item)
                            <tr>
                                <td>{{$item->product["name"]}}</td>
                                <td style="text-align: right">{{number_format($item->product["price"],0,",",".")}}</td>
                                <td class="text-center">{{$item->quantity}}</td>
                                <td style="text-align: right">{{number_format($item->price,0,",",".")}}</td>
                                <td class="text-center">
                                    @if($item->status == 'order')
                                    <span class="badge badge-danger">{{$item->status}}</span>
                                    @else
                                    <span class="badge badge-secondary">{{$item->status}}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{date('d-M-Y H:i:s', strtotime($item->created_at))}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Data Kosong</td>
                                <td></td>
                                <td></td>
                                <td></td>
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