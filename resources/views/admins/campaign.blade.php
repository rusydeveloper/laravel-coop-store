@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-tasks"></span> Campaign
                    <form action="/admin/campaign/search" method="POST" role="search">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Cari Program Bullk Buying">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default">
                                    <span class="fa fa-search"></span> Cari
                                </button>
                            </span>
                        </div>
                    </form>
                    <a href="/admin/campaign/create">
                        <button class="btn btn-primary btn-md pull-right">+ Tambah</button>
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
                    <table class="table table-striped table-hover table-responsive" style="font-size: 10pt">
                        <tr>
                            <td colspan="8">{{$campaigns->links()}}</td>
                        </tr>
                        <tr>
                            <th>Judul</th>
                            <th>status</th>
                            <th>Periode</th>
                            <th>Harga Awal</th>
                            <th>Harga Tiering</th>
                            <th>Jumlah Terbeli</th>
                            <th>Kuota Tiering</th>
                            <th>Total Transaksi</th>
                            <th>Action</th>
                        </tr>
                        <tbody>
                            @forelse($campaigns as $item)
                            <tr>
                                <td>
                                    @if(!empty($item->product["image"]))
                                    <img src="/{{$item->product["image"]}}" alt="no picture" width="75" height="75">
                                    @else
                                    <img src="{{asset('storage/products/product_default.jpg')}}" alt="no picture"
                                        width="75" height="75">

                                    @endif
                                    <br>
                                    {{$item->product["name"]}} <b>{{$item->business["name"]}}</b>
                                    {{$item->user["name"]}}</td>
                                <td>
                                    @if($item->status == 'active')
                                    <span class="badge badge-success">{{$item->status}}</span>
                                    @else
                                    <span class="badge badge-danger">{{$item->status}}</span>
                                    @endif
                                </td>
                                <td><b>{{date('d M Y g:i', strtotime($item->start_at))}} s.d
                                        {{date('d M Y G:i', strtotime($item->end_at))}}</b>
                                </td>
                                <td>{{number_format($item->product_initial_price,0,",",".")}}</td>

                                <td>
                                    {{number_format($item->product_tiering_price_1,0,",",".")}}
                                </td>
                                <td>
                                    {{number_format($item->quantity_ordered,0,",",".")}}
                                </td>
                                <td>
                                    {{number_format($item->quantity_ordered,0,",",".")}}/
                                    {{number_format($item->product_tiering_quota_1,0,",",".")}}
                                </td>
                                <td>
                                    {{number_format($item->amount_ordered,0,",",".")}}
                                </td>
                                <td>
                                    <form method="POST" action="/admin/campaign/edit" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                                        <button class="btn btn-warning btn-sm btn-space"
                                            style="float: left;">edit</button>
                                    </form>
                                    @if($item->status == 'active')
                                    <form method="POST" action="/admin/campaign/deactivate"
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                                        <button class="btn btn-danger btn-sm btn-space" style="float: left;">non
                                            aktifkan</button>
                                    </form>
                                    @else
                                    <form method="POST" action="/admin/campaign/activate" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                                        <button class="btn btn-success btn-sm btn-space"
                                            style="float: left;">aktivasi</button>
                                    </form>

                                    @endif



                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">Data Kosong</td>
                            </tr>
                            @endforelse
                            <tr>
                                <td colspan="7">{{$campaigns->links()}}</td>
                            </tr>
                        </tbody>



                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection