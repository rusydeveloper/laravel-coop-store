@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-shopping-basket"></span> Order
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
                          <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
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
                            <form method="POST" action="/admin/user/edit" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="id">
                            <button class="btn btn-warning btn-sm btn-space" style="float: left;">edit</button>
                            </form>

                            <form method="POST" action="/admin/user/delete" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="id">
                            <button class="btn btn-warning btn-sm btn-space">hapus</button>
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
