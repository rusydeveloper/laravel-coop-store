@extends('layouts.tenant')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-cutlery"></span> Produk
                    <a href="/tenant/product/create">
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
                    <table class="table table-striped table-hover" style="font-size: 10pt">
                        <thead>
                          <tr>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Usaha</th>
                            <th>Pemilik Usaha</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $item)
                      <tr>
                        <td>
                            @if(!empty($item->picture->first()->name))
                            <img src="{{asset('storage/products/'.$item->picture->first()->name)}}" alt="no picture" width="75" height="75">
                            @else
                                     <img src="{{asset('storage/products/product_default.jpg')}}" alt="no picture" width="75" height="75">
                                    
                            @endif
                             
                        </td>
                        <td>{{$item->name}}</td>
                        <td>{{number_format($item->price,0,",",".")}}</td>
                        <td>{{$item->status}}</td>
                        <td>{{$item->business->name}}</td>
                        <td>{{$item->user->name}}</td>
                        <td>
                            <form method="POST" action="/tenant/product/edit" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                            <button class="btn btn-warning btn-sm btn-space" style="float: left;">edit</button>
                            </form>
                            @if($item->status=="active")
                            <form method="POST" action="/tenant/product/nonactive" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                            <button class="btn btn-warning btn-sm btn-space">Non Aktifkan</button>
                            </form>
                            @else
                            <form method="POST" action="/tenant/product/active" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                                <button class="btn btn-warning btn-sm btn-space">Aktifkan</button>
                                </form>
                                @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td></td>
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
