@extends('layouts.tenant')

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p>Laporan Pesanan Harian pada {{date('d M Y', strtotime($date_report))}}</p>
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
                    <!-- <a href="/admin/user/add">
                    <button class="btn btn-primary btn-md pull-right">+ Tambah</button>
                    </a> -->
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
                        <td>{{$item->product->name}}</td>
                        <td style="text-align: right">{{number_format($item->product->price,0,",",".")}}</td>
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
