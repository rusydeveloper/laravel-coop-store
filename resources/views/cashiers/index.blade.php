@extends('layouts.cashier') 
@section('content')
<style type="text/css">
    .table {
        width: 100%;
        font-size: 12pt
    }

    .date-information {
        font-size: 12pt
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><span class="fa fa-shopping-basket"></span> Pesanan
                    <span class="pull-right date-information" id="live_time"></span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif @if (session('danger'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('danger') }}
                    </div>
                    @endif
                    <table class="table table-striped">
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
                                    </span> @elseif($item->status == 'paid')
                                    <span class="badge badge-secondary">
                                        {{$item->status}}
                                    </span> @elseif($item->status == 'waiting approval')
                                    <span class="badge badge-warning">
                                    {{$item->status}}
                                </span> @else
                                    <span class="badge badge-secondary">
                                        {{$item->status}}
                                    </span> @endif

                                </td>
                                <td>{{date('d-M-Y H:i:s', strtotime($item->created_at))}}</td>
                                <td>{{$item->description}}</td>
                                <td>Rp {{number_format($item->amount-$item->discount,0,",",".")}}</td>
                                <td>
                                    @if($item->status == 'unpaid')
                                    <form method="POST" action="/cashier/invoice/payment" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                                        <button class="btn btn-md btn-danger">Bayar</button>
                                    </form>
                                    @endif
                                    <form method="POST" action="/cashier/invoice/show" enctype="multipart/form-data">
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
@endsection