@extends('layouts.tenant')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-briefcase"></span> Business
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
                            <th>Status</th>
                            <th>Owner</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($businesses as $item)
                      <tr>
                        <td>{{$item->name}}</td>
                        <td>
                            @if($item->status == 'active')
                            <span class="badge badge-success">{{$item->status}}</span>
                            @else
                            <span class="badge badge-danger">{{$item->status}}</span>
                            @endif
                        </td>
                        <td>{{$item->user->name}}</td>
                        <td>{{$item->category}}</td>
                        <td>
                            <form method="POST" action="/tenant/business/edit" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
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
