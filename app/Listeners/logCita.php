<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\citaAdd;
use Illuminate\Support\Facades\Storage;

class logCita
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
     * @param  object  $event
     * @return void
     */
    public function handle(citaAdd $event)
    {
        Storage::put("logForDateOrCita.txt",$event->cita);
    }
}
