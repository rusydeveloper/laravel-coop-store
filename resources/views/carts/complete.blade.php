@extends('layouts.app')

@section('content')
<style type="text/css">
    .booking-code{
        color: #EF6C3B;
        font-weight: 800;
        width: 200px;
        text-align: center;
        border: 5px solid #EF6C3B;
        padding: 20px;
        margin: 20px;
        border-radius:10px;
        font-size: 24pt;
        display: inline-block; 
    }
    .btn-order{
    
    background-color: #4A959C;
    color: white
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        
        <div class="card" style="border: 2px solid #4A959C;">
                <!-- <div class="card-header">Pesananmu sudah selesai</div> -->
                <div class="card-body" style="text-align: center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1 style="font-size: 36pt; font-weight: 800;">
                        Terima Kasih
                    </h1>
                        <h1 style="font-size: 28pt;">Selamat Menikmati!</h1>
                    <p>berikut adalah kode pesananmu</p>
                    <div class="booking-code">
                        {{$booking_code}}
                    </div><br>
                    <button class="btn btn-lg btn-order">Cetak</button>
                    <p style="margin-top:10px">Silahkan berikan hasil cetak kode ke Kasir</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
