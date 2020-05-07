@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <span class="fa fa-shopping-basket"></span>Laporan Order Rincian Koperasi pada
          {{date('d M Y', strtotime($date_report))}}

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
          <b>{{App\Business::find($business_id)->name}}</b>
          <p>Nomor Telp<br />
            {{App\Business::find($business_id)->user['phone']}}
          </p>
          <p>Alamat<br />{{App\Business::find($business_id)->address}}</p>
          <p>Pengelompokan per produk yang <b>sudah dibayar</b></p>
          <table class="table table-striped table-hover table-responsive" style="font-size: 10pt">
            <thead>
              <tr class="text-center">
                <th>Produk</th>
                <th>Harga Satuan</th>
                <th>Kuantitas Produk Dipesan</th>
                <th>Total Transaksi</th>
                <th class="text-red">Aggregat Pesanan</th>
                <th class="text-red">Kuota Tiering 1</th>
                <th>Harga Tiering 1</th>
                <th class="text-red">Kuota Tiering 2</th>
                <th>Harga Tiering 2</th>
                <th class="text-red">Kuota Tiering 3</th>
                <th>Harga Tiering 3</th>
              </tr>
            </thead>
            <tbody>
              @forelse($orders_groupBy_product as $item)
              <tr>
                <td>{{App\Product::find($item->product_id)->name}}</td>
                <td style="text-align: right">{{number_format($item->sum/$item->quantity,0,",",".")}}</td>
                <td style="text-align: center">
                  {{number_format($item->quantity,0,",",".")}}</td>
                <td style="text-align: right">{{number_format($item->sum,0,",",".")}}</td>
                <td style="text-align: center">
                  {{App\Campaign::find($item->campaign_id)->quantity_ordered}}
                </td>
                <td style="text-align: center">
                  {{App\Campaign::find($item->campaign_id)->product_tiering_quota_1}}
                </td>
                <td style="text-align: right">
                  {{number_format(App\Campaign::find($item->campaign_id)->product_tiering_price_1,0,",",".")}}

                </td>
                <td style="text-align: center">
                  {{App\Campaign::find($item->campaign_id)->product_tiering_quota_2}}
                </td>
                <td style="text-align: right">
                  {{number_format(App\Campaign::find($item->campaign_id)->product_tiering_price_2,0,",",".")}}
                </td>
                <td style="text-align: center">
                  {{App\Campaign::find($item->campaign_id)->product_tiering_quota_3}}
                </td>
                <td style="text-align: right">
                  {{number_format(App\Campaign::find($item->campaign_id)->product_tiering_price_3,0,",",".")}}
                </td>

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