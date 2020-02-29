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
});



Pusher.log = function(msg) {
  console.log(msg);
};


</script>
helo