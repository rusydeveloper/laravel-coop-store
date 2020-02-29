@extends('layouts.app')

@section('content')
<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script>
// var pusher = new Pusher("{{env("PUSHER_KEY")}}")
// var channel = pusher.subscribe('test-channel');
// channel.bind('test-event', function(data) {
//   alert(data.text);
// });
var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
  cluster: "{{env('PUSHER_APP_CLUSTER')}}"
});

var channel = pusher.subscribe('test-channel');

channel.bind('test-event', function(data) {
  alert('An event was triggered with message: ' + data.message);
  // document.getElementById('message-realtime').innerHTML=data.message;

  document.getElementById("message-realtime").innerHTML = data.message;

});



Pusher.log = function(msg) {
  console.log(msg);
};


</script>
<!-- <div class="alert alert-success">
  <strong>Success!</strong> 
</div> -->

<div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Danger!</strong> <p id="message-realtime">hello</p>
  </div>
@endsection