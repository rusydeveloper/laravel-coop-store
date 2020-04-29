@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <span class="fa fa-money"></span> Dompet
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
              <td colspan="8">{{$wallets->links()}}</td>
            </tr>
            <tr>
              <th>Pemilik</th>
              <th>Usaha</th>
              <th>Status</th>
              <th>Saldo</th>
              <th>Action</th>
            </tr>
            <tbody>
              @forelse($wallets as $item)
              <tr>
                <td>
                  <br>
                  <b></b>
                  {{$item->user["name"]}}</td>
                <td>
                  {{$item->business["name"]}}
                </td>
                <td>
                  {{$item->status}}
                </td>
                <td>
                  {{number_format($item->balance,0,",",".")}}
                </td>

                <td>
                  <form method="POST" action="/admin/wallet/edit" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                    <button class="btn btn-warning btn-sm btn-space" style="float: left;">transaksi</button>
                  </form>
                  @if($item->status == 'active')
                  <form method="POST" action="/admin/wallet/deactivate" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                    <button class="btn btn-danger btn-sm btn-space" style="float: left;">non
                      aktifkan</button>
                  </form>
                  @else
                  <form method="POST" action="/admin/wallet/activate" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                    <button class="btn btn-success btn-sm btn-space" style="float: left;">aktivasi</button>
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
                <td colspan="7">{{$wallets->links()}}</td>
              </tr>
            </tbody>



          </table>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection