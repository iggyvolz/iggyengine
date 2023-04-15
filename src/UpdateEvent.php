<?php

namespace iggyvolz\iggyengine;

use iggyvolz\SFML\System\Time;

final class UpdateEvent
{
    public function __construct(public readonly Time $deltaTime)
    {
    }
}