@extends('layouts.test')

@section('content')
<form id="order-form" method="POST" action="/cards/order/" enctype="multipart/form-data">
  {{ csrf_field() }}
  <h4>Nomor Kartu: <input id="card_number_qr" type="text" class="form-custom form-control" name="card_number_qr"
      value="" placeholder="" required></h4>
  <button type="submit" class="btn btn-primary">
    Pemesanan
  </button>
</form>
<video id="preview"></video>
<script type="text/javascript">
  let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
      scanner.addListener('scan', function (content) {
        console.log(content);
        document.getElementById('card_number_qr').value= content;
      });
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
    var selectedCam = cameras[0];
    $.each(cameras, (i, c) => {
        if (c.name.indexOf('back') != -1) {
            selectedCam = c;
            return false;
        }
    });

    scanner.start(selectedCam);
} else {
    console.error('No cameras found.');
}
      }).catch(function (e) {
        console.error(e);
      });
</script>

@endsection