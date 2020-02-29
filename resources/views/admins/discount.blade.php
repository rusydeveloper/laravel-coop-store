@extends('layouts.admin') 
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <span class="fa fa-percent"></span> Discount
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
                <th>Kode Invoice</th>
                <th>Created At</th>
                <th>Kode Booking</th>
                <th>Status</th>
                <th>Jumlah</th>
                <th>Persentase Discount</th>
                <th>Jumlah Discount</th>
                <th>Jumlah Akhir</th>
                <th>Description</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($invoices as $item)
              <tr>
                <td>{{$item->unique_id}}</td>
                <td>{{date('d-M-Y H:i:s', strtotime($item->created_at))}}</td>
                <td>{{$item->booking_id}}</td>
                <td>
                  @if($item->status == 'unpaid')
                  <span class="badge badge-danger">{{$item->status}}</span> @else
                  <span class="badge badge-secondary">{{$item->status}}</span> @endif
                </td>
                <td style="text-align: right">
                  {{number_format($item->amount,0,",",".")}}
                </td>
                <td class="text-danger" style="text-align: center; font-weight: 900">
                  {{($item->discount/$item->amount)*100}}%
                </td>
                <td style="text-align: right">
                  {{number_format($item->discount,0,",",".")}}
                </td>
                <td style="text-align: right">
                  {{number_format($item->amount-$item->discount,0,",",".")}}
                </td>
                <td>{{$item->description}}</td>
                <td>
                  @if($item->status == 'waiting approval')
                  <form method="POST" action="/admin/invoice/discount/approve" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                    <button class="btn btn-warning btn-sm btn-space" style="float: left;">Setuju</button>
                  </form>

                  <form method="POST" action="/admin/invoice/discount/reject" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="unique_id" value="{{$item->unique_id}}">
                    <button class="btn btn-warning btn-sm btn-space" style="float: left;">Tolak</button>
                  </form>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Data Kosong</td>
                <td></td>
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