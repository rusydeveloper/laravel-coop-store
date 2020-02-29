<?php

namespace App\Listeners;

use App\Events\TestEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App;


class EventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TestEvent  $event
     * @return void
     */
    public function handle(TestEvent $event)
    {
        $pusher = App::make('pusher');
        $pusher->trigger( 'test-channel',
                      'test-event', 
                      ['message' => $event->text]);
    }
}
