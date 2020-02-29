@extends('layouts.manager')

@section('content')
<style type="text/css">
    .card-body{
        font-size: 12pt;
        text-align: left
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Buat Rekap</div>
                <div class="card-body">
                    <form method="POST" action="/manager/recap/order" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="owner" class="col-md-4 col-form-label text-md-right">Business Owner</label>
                            <div class="col-md-6">
                                <select id="owner" name="owner" class="form-control{{ $errors->has('owner') ? ' is-invalid' : '' }}">
                                    @forelse($businesses as $item)
                                    <option value="{{$item->user->id}}">{{$item->name}}</option>
                                    @empty
                                    <option value="">Silahkan Buat Usaha terlebih dahulu</option>
                                    @endforelse
                                </select>

                                @if ($errors->has('owner'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('owner') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Buat Rekapan
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
