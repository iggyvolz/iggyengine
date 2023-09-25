<?php

namespace iggyvolz\iggyengine;

use iggyvolz\SFML\Graphics\RenderTarget;

final readonly class RenderEvent
{
    public function __construct(public RenderTarget $target)
    {
    }
}