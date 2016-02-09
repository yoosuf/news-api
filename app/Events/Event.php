<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

abstract class Event
{
    use SerializesModels;

    protected $listen = [
        'Dingo\Api\Event\ResponseWasMorphed' => [
            'App\Listeners\AddPaginationLinksToResponse'
        ]
    ];
}
