<?php

namespace App\Listeners;

use App\Events\PrivateChatEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PrivateChatListener
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
     * @param  PrivateChatEvent  $event
     * @return void
     */
    public function handle(PrivateChatEvent $event)
    {
        //
    }
}
