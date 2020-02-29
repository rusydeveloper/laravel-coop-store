@extends('layouts.admin')

@section('content')
<style type="text/css">
    .report-container {
        margin-bottom: 50px;
        text-align: center
    }
</style>
<div class="container">
    <div class="row justify-content-center report-container">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-user"></span> Jumlah Tenant</div>
                <div class="card-body">
                    <span>{{$users->where('role','tenant')->count()}}</span>
                    <p>User</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-shopping-basket"></span> Jumlah Tagihan</div>
                <div class="card-body">
                    <span>{{number_format($invoices->where('status','paid')->count(),0,",",".")}}</span>
                    <p>Tagihan</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-money"></span> Jumlah Pemasukan</div>
                <div class="card-body">
                    <span>{{number_format($invoices->where('status','paid')->sum('amount'),0,",",".")}}</span>
                    <p>Rupiah</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center report-container">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-suitcase"></span> Jumlah Usaha Aktif</div>
                <div class="card-body">
                    <span>{{$businesses->where('status','active')->count()}}</span>
                    <p>Usaha</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="fa fa-cutlery"></span> Jumlah Produk Aktif</div>
                <div class="card-body">
                    <span>{{$products->where('status','active')->count()}}</span>
                    <p>Produk</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection