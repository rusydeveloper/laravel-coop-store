@extends('layouts.admin')

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
                    Jumlah Pemasukan
                </div>
                <div class="card-body">
                    {{number_format($invoices->where('status', 'paid')->sum('amount')*0.25,0,",",".")}}
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center text-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Jumlah Tagihan
                </div>
                <div class="card-body">
                    {{number_format($invoices->count(),0,",",".")}}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Jumlah Tagihan Dibayar
                </div>
                <div class="card-body">
                    {{number_format($invoices->where('status', 'paid')->count(),0,",",".")}}
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
                    <input type="text" class="input-search" id="searchInvoiceCode" onkeyup="searchInvoice()"
                        placeholder="Masukan Usaha dan Kode Booking">
                    <table id="invoiceTable" class="table table-striped table-hover" style="font-size: 10pt">
                        <thead>
                            <tr>
                                <th>Nama Tenant dan Nama Usaha</th>
                                <th>Created At</th>
                                <th>Kode Booking</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Description</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $item)
                            <tr>
                                <td>{{$item->business->name}}</td>
                                <td>{{date('d-M-Y H:i:s', strtotime($item->created_at))}}</td>
                                <td>{{$item->booking_id}}</td>
                                <td>
                                    @if($item->status == 'unpaid')
                                    <span class="badge badge-danger">{{$item->status}}</span>
                                    @else
                                    <span class="badge badge-secondary">{{$item->status}}</span>
                                    @endif
                                </td>
                                <td style="text-align: right">
                                    {{number_format($item->amount,0,",",".")}}
                                </td>
                                <td>{{$item->description}}</td>
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