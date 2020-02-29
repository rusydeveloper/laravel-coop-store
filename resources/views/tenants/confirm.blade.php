@extends('layouts.tenant')

@section('content')

<style type="text/css">
 .confirmation-container{
    width: 80%;
    margin: auto;
    background-color: white;
    border-radius: 20px;
    padding: 10px;

}

.alert{
    width: 100%;
    margin-top: 10px;
    margin-bottom: 10px;
    font-weight: 900;
}
.highlight{
   font-weight: 900;
   font-size: 14pt;
   color: #41AA44; 
}

</style>
<div class="container" style="margin-bottom: 100px; text-align: center;">
    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                     @elseif (session('danger'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('danger') }}
                    </div>
                    @endif
    <div class="confirmation-container">
            <p>Pesanan Berhasil Dikirim Ke Kasir</p>
            <p>Kode Booking: <span class="highlight">{{$confirmationCode}}</span></p>
            <p>Pelanggan:<span class="highlight"> {{$customerInfo}}</span></p>
            <a href="https://www.warung-makan.com/manager">
            <button class="btn btn-success">Ke Menu Utama</button></a>
    </div>
</div>

<script type="text/javascript">

</script>
@endsection
