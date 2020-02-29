@extends('layouts.tenant')

@section('content')
<style type="text/css">
.card-body{
    font-size: 12pt;
    text-align: left
}
</style>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

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
                    <form method="POST" action="/tenant/product/update" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="unique_id" value="{{$product->unique_id}}">
                        <div class="form-group row">
                            <label for="owner" class="col-md-4 col-form-label text-md-right">Product Owner</label>
                            <div class="col-md-6">
                                <select id="owner" name="owner" class="form-control{{ $errors->has('owner') ? ' is-invalid' : '' }}">
                                    <option value="{{$product->business->unique_id}}" selected>{{$product->business->name}}</option>
                                    @forelse($businesses as $item)
                                    <option value="{{$item->unique_id}}">{{$item->name}}</option>
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
                                <select id="status" name="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}">
                                    <option value="{{$product->status}}" selected>{{$product->status}}</option>
                                    <option value="active">Active</option>
                                    <option value="non active">Non Active</option>
                                    <option value="out of stock">Habis</option>
                                </select>
                                @if ($errors->has('role'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('role') }}</strong>
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
                                <div>
                                    @forelse($pictures as $item)
                                    <img src="{{asset('storage/products/'.$item->name)}}" alt="no picture" width="200">
                                    @empty
                                    <p>Default Picture</p>
                                    <img src="{{asset('storage/products/product_default.jpg')}}" alt="no picture" width="200">
                                    @endforelse
                                   
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Product Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$product->name}}" required>
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">Product Price</label>
                            <div class="col-md-6">
                                <input id="price" type="text" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{$product->price}}" required>
                                @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">Product Category</label>
                            <div class="col-md-6">
                                <select id="category" name="category" class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}">
                                    <option value="{{$product->category}}" selected>{{$product->category}}</option>
                                    <option value="Cemilan">Cemilan</option>
                                    <option value="Makanan">Makanan</option>
                                    <option value="Minuman">Minuman</option>
                                    <option value="Penutup">Penutup</option>
                                </select>
                                @if ($errors->has('category'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subcategory" class="col-md-4 col-form-label text-md-right">Product Subcategory</label>
                            <div class="col-md-6">
                                <select id="subcategory" name="subcategory" class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}">
                                    <option value="{{$product->subcategory}}" selected>{{$product->subcategory}}</option>
                                    <option value="Indonesian">Indonesia</option>
                                    <option value="West">West</option>
                                    <option value="European">European</option>
                                    <option value="Asian">Asian</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Japanese">Japanese</option>
                                    <option value="Korean">Korean</option>
                                    <option value="Vietnamese">Vietnamese</option>
                                    <option value="Mediterranean">Arabic</option>
                                    <option value="Italian">Italian</option>
                                </select>
                                @if ($errors->has('category'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-form-label text-md-right">Description</label>
                            <textarea class="form-control summernote" rows="4" id="description" name="description" required>{{$product->description}}</textarea>
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
