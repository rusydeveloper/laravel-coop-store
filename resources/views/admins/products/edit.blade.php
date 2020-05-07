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
                <div class="card-header">Edit Product</div>
                <div class="card-body">
                    <form method="POST" action="/admin/product/update" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="unique_id" value="{{$product->unique_id}}">
                        <div class="form-group row">
                            <label for="owner" class="col-md-4 col-form-label text-md-right">Product Owner</label>
                            <div class="col-md-6">
                                <select id="owner" name="owner"
                                    class="form-control{{ $errors->has('owner') ? ' is-invalid' : '' }}">
                                    <option value="{{$product->business["id"]}}" selected>
                                        {{$product->business["name"]}}</option>
                                    @forelse($businesses as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @empty
                                    <option value="">Silahkan Buat Business terlebih dahulu</option>
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
                                    <option value="{{$product->status}}" selected>{{$product->status}}</option>
                                    <option value="active">Active</option>
                                    <option value="non active">Non Active</option>
                                </select>
                                @if ($errors->has('role'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('role') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Product Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                    value="{{$product->name}}" required>
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="variation" class="col-md-4 col-form-label text-md-right">Variation</label>
                            <div class="col-md-6">
                                <input id="variation" type="text"
                                    class="form-control{{ $errors->has('variation') ? ' is-invalid' : '' }}"
                                    name="variation" value="{{$product->variation}}" required>
                                @if ($errors->has('variation'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('variation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="retail_unit" class="col-md-4 col-form-label text-md-right">Retail Unit</label>
                            <div class="col-md-6">
                                <input id="retail_unit" type="text"
                                    class="form-control{{ $errors->has('retail_unit') ? ' is-invalid' : '' }}"
                                    name="retail_unit" value="{{$product->retail_unit}}" required>
                                @if ($errors->has('retail_unit'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('retail_unit') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bulk_unit" class="col-md-4 col-form-label text-md-right">Bulk Unit</label>
                            <div class="col-md-6">
                                <input id="bulk_unit" type="text"
                                    class="form-control{{ $errors->has('bulk_unit') ? ' is-invalid' : '' }}"
                                    name="bulk_unit" value="{{$product->bulk_unit}}" required>
                                @if ($errors->has('bulk_unit'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('bulk_unit') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bulk_to_retail" class="col-md-4 col-form-label text-md-right">Bulk to Retail
                                Unit</label>
                            <div class="col-md-6">
                                <input id="bulk_to_retail" type="number"
                                    class="form-control{{ $errors->has('bulk_to_retail') ? ' is-invalid' : '' }}"
                                    name="bulk_to_retail" value="{{$product->bulk_to_retail}}" required>
                                @if ($errors->has('bulk_to_retail'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('bulk_to_retail') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="buying_price" class="col-md-4 col-form-label text-md-right">Supplier
                                Price</label>
                            <div class="col-md-6">
                                <input id="buying_price" type="text"
                                    class="form-control{{ $errors->has('buying_price') ? ' is-invalid' : '' }}"
                                    name="buying_price" value="{{$product->buying_price}}" required>
                                @if ($errors->has('buying_price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('buying_price') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">Product Price</label>
                            <div class="col-md-6">
                                <input id="price" type="text"
                                    class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price"
                                    value="{{$product->price}}" required>
                                @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subcategory" class="col-md-4 col-form-label text-md-right">Product
                                Subcategory</label>
                            <div class="col-md-6">
                                <select id="subcategory" name="subcategory"
                                    class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}">
                                    <option value="{{$product->category_id}}" selected>{{$product->category["name"]}}
                                    </option>
                                    @forelse($categories as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @empty
                                    <option value="" selected>List Kategori
                                    </option>
                                    @endforelse
                                </select>
                                @if ($errors->has('category'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Display Picture</label>
                            <div class="col-md-6" style="text-align: center">
                                <div class="img-container" style="padding:20px">
                                    <input type="file" name="picture_file" value="">
                                </div>
                                <span><img src="/{{$product->image}}" /></span>
                                <div>
                                    <p>Default Picture</p>
                                    <img src="{{asset('storage/products/product_default.jpg')}}" alt="no picture"
                                        width="200">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Edit Product
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