@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-cutlery"></span> Product

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
                        <thead>
                            <tr>
                                <th>Picture</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Owner</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $item)
                            <tr>
                                <td>
                                    @if(!empty($item->picture->first()->name))
                                    <img src="{{asset('storage/products/'.$item->picture->first()->name)}}"
                                        alt="no picture" width="75" height="75">
                                    @else
                                    <img src="{{asset('storage/products/product_default.jpg')}}" alt="no picture"
                                        width="75" height="75">

                                    @endif

                                </td>
                                <td>{{$item->name}}</td>
                                <td>{{number_format($item->price,0,",",".")}}</td>
                                <td>
                                    @if($item->status == 'active')
                                    <span class="badge badge-success">{{$item->status}}</span>
                                    @else
                                    <span class="badge badge-danger">{{$item->status}}</span>
                                    @endif
                                </td>
                                <td>
                                    <b>{{$item->business->name}}</b>
                                    {{$item->user->name}}
                                </td>
                                <td>
                                    <form method="POST" action="/admin/product/edit" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                                        <button class="btn btn-warning btn-sm btn-space"
                                            style="float: left;">edit</button>
                                    </form>
                                    @if($item->status == 'active')
                                    <form method="POST" action="/admin/product/deactivate"
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                                        <button class="btn btn-danger btn-sm btn-space" style="float: left;">non
                                            aktifkan</button>
                                    </form>
                                    @else
                                    <form method="POST" action="/admin/product/activate" enctype="multipart/form-data">
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


                        {{$products->links()}}
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection