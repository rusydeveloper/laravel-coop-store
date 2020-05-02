@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-credit-card"></span> Payment
                    <a href="/admin/payment/create">
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
                                <th>Name</th>
                                <th>Method</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{$item->category}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>
                                    <div class="flex-container">
                                        <div>
                                            <form method="POST" action="/admin/payment/edit"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                                                <button class="btn btn-warning btn-sm btn-space"
                                                    style="float: left;">edit</button>
                                            </form>
                                        </div>
                                        <div>
                                            <form method="POST" action="/admin/payment/delete"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                                                <button class="btn btn-warning btn-sm btn-space">hapus</button>
                                            </form>
                                        </div>
                                    </div>



                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td></td>
                                <td>Belum ada data</td>
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