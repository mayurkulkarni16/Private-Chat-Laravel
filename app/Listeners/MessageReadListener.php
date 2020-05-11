<?php

namespace App\Listeners;

use App\Events\MessageReadEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MessageReadListener
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
     * @param  MessageReadEvent  $event
     * @return void
     */
    public function handle(MessageReadEvent $event)
    {
        //
    }
}
