@extends('layouts.tenant')

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p>Laporan Penjualan Harian pada {{date('d M Y', strtotime($date_report))}}</p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center text-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Jumlah Penjualan
                </div>
                <div class="card-body">
                    {{number_format($invoices->where('status', 'paid')->sum('amount'),0,",",".")}}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Jumlah Pemasukan Bersih
                </div>
                <div class="card-body">
                    {{number_format($invoices->where('status', 'paid')->sum('amount')*0.75,0,",",".")}}
                </div>
            </div>
        </div>
    </div>
    <hr>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-clone"></span> Rincian Tagihan
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
                    <table class="table table-striped table-hover table-condensed table-responsive" style="font-size: 10pt">
                        <thead>
                          <tr>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $item)
                      <tr>
                        <td>
                            <p>{{$item->description}} <br>
                            {{$item->booking_id}}</p>
                        </td>
                        <td>
                            @if($item->status == 'unpaid')
                            <span class="badge badge-danger">{{$item->status}}</span>
                            @else
                            <span class="badge badge-secondary">{{$item->status}}</span>
                            @endif
                            <br>{{date('d-M-Y H:i:s', strtotime($item->updated_at))}}
                        </td>
                        <td style="text-align: right">
                           Rp {{number_format($item->amount,0,",",".")}}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td></td>
                        <td>Data Kosong</td>
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
