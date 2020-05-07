@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <span class="fa fa-cubes"></span> Product
          <form action="/admin/product/search" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
              <input type="text" class="form-control" name="q" placeholder="Cari Produk"> <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                  <span class="fa fa-search"></span> Cari
                </button>
              </span>
            </div>
          </form>
          <a href="/admin/product/create">
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
              <th>Picture</th>
              <th>Name</th>
              <th>Supplier Price</th>
              <th>Product Price</th>
              <th>Status</th>
              <th>Owner</th>
              <th>Action</th>
            </tr>
            <tbody>
              @forelse($products as $item)
              <tr>
                <td>
                  @if(!empty($item->picture->first()->name))
                  <img src="{{asset('storage/products/'.$item->picture->first()->name)}}" alt="no picture" width="75"
                    height="75">
                  <img src="{{asset('storage/products/'.$item->image)}}" alt="no picture" width="75" height="75">
                  @else
                  <img src="{{asset('storage/products/product_default.jpg')}}" alt="no picture" width="75" height="75">

                  @endif

                </td>
                <td>{{$item->name}}</td>
                <td>{{number_format($item->buying_price,0,",",".")}}</td>
                <td>{{number_format($item->price,0,",",".")}}</td>
                <td>
                  @if($item->status == 'active')
                  <span class="badge badge-success">{{$item->status}}</span>
                  @else
                  <span class="badge badge-danger">{{$item->status}}</span>
                  @endif
                </td>
                <td>
                  <b>{{$item->business["name"]}}</b>
                  {{$item->user["name"]}}
                </td>
                <td>
                  <form method="POST" action="/admin/product/edit" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                    <button class="btn btn-warning btn-sm btn-space" style="float: left;">edit</button>
                  </form>
                  @if($item->status == 'active')
                  <form method="POST" action="/admin/product/deactivate" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                    <button class="btn btn-danger btn-sm btn-space" style="float: left;">non
                      aktifkan</button>
                  </form>
                  @else
                  <form method="POST" action="/admin/product/activate" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                    <button class="btn btn-success btn-sm btn-space" style="float: left;">aktivasi</button>
                  </form>
                  @endif
                </td>
              </tr>
              @empty
              <b>Data kosong, coba kata kunci lain</b>
              @endforelse
            </tbody>
          </table>


        </div>
      </div>
    </div>
  </div>
</div>
@endsection