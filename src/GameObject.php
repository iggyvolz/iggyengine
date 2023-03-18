<?php

namespace iggyvolz\iggyengine;

use iggyvolz\SFML\Graphics\Drawable;
use iggyvolz\SFML\Graphics\RenderStates;
use iggyvolz\SFML\Graphics\RenderTarget;
use iggyvolz\SFML\Graphics\Transform;
use iggyvolz\SFML\Graphics\Transformable;
use iggyvolz\SFML\System\Vector\Vector2F;
use League\Event\EventDispatcher;

class GameObject implements Drawable, Transformable
{
    public readonly EventDispatcher $eventDispatcher;
    public function __construct(
        protected Transformable $sprite,
        public readonly Stage $stage,
        public readonly int $priority,
    )
    {
        $this->eventDispatcher = new EventDispatcher();
        $stage->add($this, $this->priority);
    }

    public function draw(RenderTarget $target, ?RenderStates $renderStates = null): void
    {
        if($this->sprite instanceof Drawable) {
            $this->sprite->draw($target, $renderStates);
        }
    }

    public function setPosition(Vector2F $position): void
    {
        $this->sprite->setPosition($position);
    }

    public function setRotation(float $angle): void
    {
        $this->sprite->setRotation($angle);
    }

    public function setScale(Vector2F $scale): void
    {
        $this->sprite->setScale($scale);
    }

    public function setOrigin(Vector2F $origin): void
    {
        $this->sprite->setOrigin($origin);
    }

    public function getPosition(): Vector2F
    {
        return $this->sprite->getPosition();
    }

    public function getRotation(): float
    {
        return $this->sprite->getRotation();
    }

    public function getScale(): Vector2F
    {
        return $this->sprite->getScale();
    }

    public function getOrigin(): Vector2F
    {
        return $this->sprite->getOrigin();
    }

    public function move(Vector2F $offset): void
    {
        $this->sprite->move($offset);
    }

    public function rotate(float $offset): void
    {
        $this->sprite->rotate($offset);
    }

    public function scale(Vector2F $offset): void
    {
        $this->sprite->scale($offset);
    }

    public function getTransform(): Transform
    {
        return $this->sprite->getTransform();
    }

    public function getInverseTransform(): Transform
    {
        return $this->sprite->getInverseTransform();
    }
}