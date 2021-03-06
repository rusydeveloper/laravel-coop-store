@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <span class="fa fa-shopping-basket"></span>Laporan Order Rincian Supplier
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
          <p>Pengelompokan per supplier yang <b>sudah dibayar</b></p>
          <table class="table table-striped table-hover" style="font-size: 10pt">
            <thead>
              <tr class="text-center">
                <th>Produk</th>
                <th>Kuantitas Produk Dipesan</th>
                <th>Total Transaksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($orders_groupBy_product as $item)
              <tr>
                <td>{{App\Product::find($item->product_id)->name}}</td>
                <td style="text-align: center">
                  {{number_format($item->quantity,0,",",".")}}</td>
                <td style="text-align: right">Rp {{number_format($item->sum,0,",",".")}}</td>
              </tr>
              @empty
              <tr>
                <td colspan="5">Data Kosong</td>

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