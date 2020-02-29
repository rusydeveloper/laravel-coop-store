<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;


class NotificationController extends Controller
{
    public function getIndex()
    {
        return view('notification');
    }

    public function postNotify(Request $request)
    {
        $notifyText = e($request->input('notify_text'));
        // return $notifyText;
        // TODO: Get Pusher instance from service container
        $pusher = App::make('pusher');
        $pusher->trigger( 'test-channel',
                      'test-event', 
                      ['message' => $notifyText]);
        // TODO: The notification event data should have a property named 'text'

        // TODO: On the 'notifications' channel trigger a 'new-notification' event
    }
}
