<?php

namespace App;

use Illuminate\Mail\TransportManager;
use App\IntercomTransport;

class IntercomTransportManager extends TransportManager
{
    protected function createIntercomDriver()
    {
        $config = $this->app['config']->get('services.intercom', []);
        return new IntercomTransport($config['token']);
    }

}
