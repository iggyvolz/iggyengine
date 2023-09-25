<?php

namespace iggyvolz\iggyengine;

use iggyvolz\SFML\System\Time;

final readonly class UpdateEvent
{
    public function __construct(public Time $deltaTime)
    {
    }
}