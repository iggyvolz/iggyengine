<?php

namespace iggyvolz\iggyengine;

use iggyvolz\SFML\Event\Event;
use iggyvolz\SFML\System\Time;
use iggyvolz\SFML\Window\Window;

final  class UpdateEvent extends Event
{
    public function __construct(Window $window, public readonly Time $deltaTime)
    {
        parent::__construct($window);
    }
}