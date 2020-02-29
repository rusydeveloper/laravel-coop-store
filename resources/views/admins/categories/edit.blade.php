@extends('layouts.admin')

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
                <div class="card-header">Edit Category</div>
                <div class="card-body">
                    <form method="POST" action="/admin/category/update" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="unique_id" value="{{$category->unique_id}}">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Category Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$category->name}}" required>
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="owner" class="col-md-4 col-form-label text-md-right">Category Owner</label>
                            <div class="col-md-6">
                                <select id="owner" name="owner" class="form-control{{ $errors->has('owner') ? ' is-invalid' : '' }}">
                                    <option value="{{$category->business->unique_id}}" selected>{{$category->business->name}}</option>
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
                                    <option value="{{$category->status}}" selected>{{$category->status}}</option>
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
                        
                        
                        
                        <div class="form-group">
                            <label for="description" class="col-form-label text-md-right">Description</label>
                            <textarea class="form-control summernote" rows="4" id="description" name="description" required>{{$category->description}}</textarea>
                        </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Edit Category
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
