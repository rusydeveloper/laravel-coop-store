@extends('layouts.tenant')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-shopping-basket"></span> Pesanan
                    
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
                          <tr>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $item)
                      <tr>
                        <td>{{$item->product->name}}</td>
                        <td>{{$item->product->price}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->price}}</td>
                        <td>
                        @if($item->status == 'order')
                            <span class="badge badge-danger">{{$item->status}}</span>
                            @else
                            <span class="badge badge-secondary">{{$item->status}}</span>
                            @endif
                        </td>
                        <td>
                            {{date('d-M-Y H:i:s', strtotime($item->created_at))}}
                        </td>
                        <td>
                            <form method="POST" action="/admin/order/edit" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="order_id" value="{{$item->id}}">
                            <button class="btn btn-warning btn-sm btn-space" style="float: left;">edit</button>
                            </form>
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
