<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
/*use App\Models\Contact;
use App\Models\Message;*/

    class MessageEvent implements ShouldBroadcast
    {
        use Dispatchable, InteractsWithSockets, SerializesModels;

        //public $message;
       // public $contact;
        public $today_sent;
        public $unread;

        /**
         * Create a new event instance.
         *
         * @param  $comment
         *
         * @return void
         */

       
        public function __construct(/*Contact $contact, Message $message,*/  $today_sent, $unread)
        {
            //
           // $this->contact = $contact;
           // $this->message = $message;
            $this->today_sent = $today_sent;
            $this->unread = $unread;
        }

        /**
         * Get the channels the event should broadcast on.
         *
         * @return \Illuminate\Broadcasting\Channel|array
         */

        public function broadcastOn()
        {
            return new Channel('message-channel');
            
        }

    }