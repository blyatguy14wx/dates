<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\citas;

class citaAdd implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $cita;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(citas $cita)
    {  
       $this->cita = $cita;
    }

    public function broadcastOn()
    {
        return ["citaAddEvent"];
    }

    public function BroadCastAs(){
        return "newCita";
    }
}
