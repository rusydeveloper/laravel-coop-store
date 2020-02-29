@extends('layouts.tenant')

@section('content')
<form id="order-form" method="POST" action="cards/order/" enctype="multipart/form-data">
  {{ csrf_field() }}
  <h4>Nomor Kartu: <input id="card_number_qr" type="text" class="form-custom form-control" name="card_number_qr"
      value="" placeholder="" required></h4>
  <button type="submit" class="btn btn-success">
    Pemesanan
  </button>
</form>
<video id="preview"></video>
<script type="text/javascript"
  src="https://rawcdn.githack.com/tobiasmuehl/instascan/4224451c49a701c04de7d0de5ef356dc1f701a93/bin/instascan.min.js">
</script>
<script src="{{ asset('js/instascan.min.js') }}"></script>
<script type="text/javascript">
  let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false });
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