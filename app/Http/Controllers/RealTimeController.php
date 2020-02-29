<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TestEvent;
use App;
use Pusher\Laravel\Facades\Pusher;




class RealTimeController extends Controller
{
	public function event(){
		$text = 'event at '.date('H:i:s');
		event(new TestEvent($text));

		return view('realtimes.index');
	}

	public function trial(){
		$pusher = App::make('pusher');
		$text = date('H:i:s');
		$pusher->trigger( 'test-channel',
			'test-event', 
			array('message' => $text));
		return view('realtimes.index');
	}

	public function mychannel(){

		$message = 'Hey this is my channel dude';
		Pusher::trigger('test-channel', 'test-event', ['message' => $message]);
// We're done here - how easy was that, it just works!
		return view('realtimes.index');
	}

	public function waiting(){
		return view('realtimes.waiting');
	}
}


