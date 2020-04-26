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
                <div class="card-header">Create Campaign</div>
                <div class="card-body">
                    <form method="POST" action="/admin/campaign/store" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="product_id" class="col-md-4 col-form-label text-md-right">Product</label>
                            <div class="col-md-6">
                                <select id="product_id" name="product_id"
                                    class="form-control{{ $errors->has('product_id') ? ' is-invalid' : '' }}">
                                    <option value="" selected>Kosong
                                    </option>
                                    @forelse($products as $item)
                                    <option value="{{$item->unique_id}}">{{$item->business["name"]}} - {{$item->name}}
                                    </option>
                                    @empty
                                    <option value="">Silahkan Buat Produk terlebih dahulu</option>
                                    @endforelse
                                </select>

                                @if ($errors->has('owner'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('owner') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">Status</label>
                            <div class="col-md-6">
                                <select id="status" name="status"
                                    class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}">
                                    <option value="active">Active</option>
                                    <option value="non active" selected>Non Active</option>
                                </select>
                                @if ($errors->has('role'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('role') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Judul</label>
                            <div class="col-md-6">
                                <input id="title" type="text"
                                    class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                                    value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product_initial_price" class="col-md-4 col-form-label text-md-right">Harga
                                Awal</label>
                            <div class="col-md-6">
                                <input id="product_initial_price" type="text"
                                    class="form-control{{ $errors->has('product_initial_price') ? ' is-invalid' : '' }}"
                                    name="product_initial_price" value="{{ old('product_initial_price') }}" required>
                                @if ($errors->has('product_initial_price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('product_initial_price') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product_tiering_price_1" class="col-md-4 col-form-label text-md-right">Harga
                                Tiering</label>
                            <div class="col-md-6">
                                <input id="product_tiering_price_1" type="text"
                                    class="form-control{{ $errors->has('product_tiering_price_1') ? ' is-invalid' : '' }}"
                                    name="product_tiering_price_1" value="{{ old('product_tiering_price_1') }}"
                                    required>
                                @if ($errors->has('product_tiering_price_1'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('product_tiering_price_1') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product_tiering_quota_1" class="col-md-4 col-form-label text-md-right">Kuota
                                Tiering</label>
                            <div class="col-md-6">
                                <input id="product_tiering_quota_1" type="text"
                                    class="form-control{{ $errors->has('product_tiering_quota_1') ? ' is-invalid' : '' }}"
                                    name="product_tiering_quota_1" value="{{ old('product_tiering_quota_1') }}"
                                    required>
                                @if ($errors->has('product_tiering_quota_1'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('product_tiering_quota_1') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product_tiering_max" class="col-md-4 col-form-label text-md-right">Maksimal
                                Kuota
                            </label>
                            <div class="col-md-6">
                                <input id="product_tiering_max" type="text"
                                    class="form-control{{ $errors->has('product_tiering_max') ? ' is-invalid' : '' }}"
                                    name="product_tiering_max" value="{{ old('product_tiering_max') }}" required>
                                @if ($errors->has('product_tiering_max'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('product_tiering_max') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start_at" class="col-md-4 col-form-label text-md-right">Waktu Mulai</label>
                            <div class="col-md-6">
                                <input id="start_at" type="datetime-local"
                                    class="form-control{{ $errors->has('start_at') ? ' is-invalid' : '' }}"
                                    name="start_at" value="{{ old('start_at') }}" required>
                                @if ($errors->has('start_at'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('start_at') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="end_at" class="col-md-4 col-form-label text-md-right">Waktu Berakhir</label>
                            <div class="col-md-6">
                                <input id="end_at" type="datetime-local"
                                    class="form-control{{ $errors->has('end_at') ? ' is-invalid' : '' }}" name="end_at"
                                    value="{{ old('end_at') }}" required>
                                @if ($errors->has('end_at'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('end_at') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Create Campaign
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