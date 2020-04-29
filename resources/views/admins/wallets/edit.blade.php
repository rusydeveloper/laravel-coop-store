@extends('layouts.admin')

@section('content')
<style type="text/css">
    .card-body {
        font-size: 12pt;
        text-align: left
    }
</style>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-*.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Dompet</div>
                <div class="card-body">
                    <h4>Keterangan Dompet</h4>
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <td style="width:500px">Pemilik</td>
                            <td style="width:500px"><b>{{$wallet->user["name"]}}</b></td>
                        </tr>
                        <tr>
                            <td>Usaha</td>
                            <td><b>{{$wallet->business["name"]}}</b></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><b>{{$wallet->status}}</b></td>
                        </tr>
                        <tr>
                            <td>Saldo</td>
                            <td><b> Rp {{number_format($wallet->balance,0,",",".")}}</b></td>
                        </tr>

                    </table>

                    <form method="POST" action="/admin/wallet/update" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="unique_id" value="{{$wallet->unique_id}}">

                        <div class="form-group row">
                            <label for="product_id" class="col-md-4 col-form-label text-md-right">Tipe Transaksi</label>
                            <div class="col-md-6">

                                <select id="method" name="method"
                                    class="form-control{{ $errors->has('method') ? ' is-invalid' : '' }}">
                                    <option value="TOP UP" selected>
                                        TOP UP
                                    </option>
                                    <option value="WITHDRAW">
                                        TARIK
                                    </option>
                                </select>

                                @if ($errors->has('method'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('method') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">Status</label>
                            <div class="col-md-6">
                                <select id="status" name="status"
                                    class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}">
                                    <option value="{{$wallet->status}}" selected>{{$wallet->status}}</option>
                                    <option value="active">Active</option>
                                    <option value="non active">Non Active</option>
                                    <option value="finish">Finish</option>
                                </select>
                                @if ($errors->has('role'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('role') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">Nilai Transaksi</label>
                            <div class="col-md-6">
                                <input id="amount" type="text"
                                    class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount"
                                    value="0">
                                @if ($errors->has('amount'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Transaksi
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection