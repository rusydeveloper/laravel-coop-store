@extends('layouts.tenant')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-user"></span> Pengguna
                    
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
                            <th>Peran</th>
                            <th>Status</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $item)
                      <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->role}}</td>
                        <td>{{$item->status}}</td>
                        <td>{{$item->email}}</td>
                        <td style="width: 300px">
                            <form method="POST" action="/admin/user/edit" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{$item->unique_id}}">
                            <button class="btn btn-warning btn-sm btn-space" style="float: left;">edit</button>
                            </form>

                            <form method="POST" action="/admin/user/reset-password" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{$item->unique_id}}">
                            <button class="btn btn-secondary btn-sm btn-space" style="float: left;">reset password</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
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
