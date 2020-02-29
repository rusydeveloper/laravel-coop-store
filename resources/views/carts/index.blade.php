@extends('layouts.app')

@section('content')
<style>
.btn-order{
    width: 100%;
    background-color: #EF6C3B;
    color: white
}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="border: 2px solid #4A959C">
                <div class="card-header" style="background-color: #CDE0E2; font-size: 16pt; font-weight: 900; letter-spacing: 1px">Yang Dipesan</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <table class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Pesanan</th>
                                <th style="text-align:center">Harga</th>
                                <th style="text-align:left">Jumlah</th>
                                <th style="text-align:right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cart as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td class="text-center">{{$item->price(null,'.',',')}}</td>
                                <td style="text-align: center; float: left">
                                    <table>
                                        <tr>
                                            <td>
                                                <form method="POST" action="/cart/minus" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="rowId" value="{{$item->rowId}}">
                                                    <button class="btn btn-sm btn-primary" type="submit">-</button>
                                                </form>
                                            </td>
                                            <td>
                                                {{$item->qty}}
                                            </td>
                                            <td>
                                                <form method="POST" action="/cart/plus" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="rowId" value="{{$item->rowId}}">
                                                    <button class="btn btn-sm btn-primary" type="submit" style="">+</button>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="POST" action="/cart/remove" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="rowId" value="{{$item->rowId}}">
                                                    <button class="btn btn-sm" type="submit">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </td>
                                <td style="text-align:right">
                                    
                                        
                                                {{$item->total(null,'.',',')}}
                                            </td>
                                            



                                <!-- <form method="POST" action="/cart/detail" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="rowId" value="{{$item->rowId}}">
                                <button class="btn btn-sm" type="submit">detail</button>
                            </form> -->
                            
                        </td>
                        @empty
                        <tr>
                            <td></td>
                            <td>Belum Ada Pesanan</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforelse

                        <tr>
                            <td>Total</td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right;">{{Cart::total()}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <a href="/cart/delete">
                                    <button class="btn btn-secondary">Hapus Semua</button>
                                </a>
                            </td>
                            <td>
                                <form method="GET" action="/order/submit" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <button class="btn btn-order btn-md pull-right">Pesan</button>
                                </td>

                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
