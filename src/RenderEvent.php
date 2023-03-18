<?php

namespace iggyvolz\iggyengine;

use iggyvolz\SFML\Event\Event;
use iggyvolz\SFML\Window\Window;

final class RenderEvent extends Event
{
    public function __construct(Window $window)
    {
        parent::__construct($window);
    }
}