<?php

namespace iggyvolz\iggyengine;

use iggyvolz\SFML\Audio\AudioLib;
use iggyvolz\SFML\Event\ClosedEvent;
use iggyvolz\SFML\Graphics\GraphicsLib;
use iggyvolz\SFML\Graphics\RenderWindow;
use iggyvolz\SFML\System\Clock;
use iggyvolz\SFML\System\SystemLib;
use iggyvolz\SFML\Window\WindowLib;
use League\Event\EventDispatcher;
use Revolt\EventLoop;

class Stage
{
    public readonly EventDispatcher $eventDispatcher;

    public function __construct(
        public readonly RenderWindow $target,
        public readonly int $fps,
        public readonly SystemLib $systemLib,
        public readonly AudioLib $audioLib,
        public readonly GraphicsLib $graphicsLib,
        public readonly WindowLib $windowLib,
    )
    {
        $this->eventDispatcher = new EventDispatcher();
        $this->eventDispatcher->subscribeTo(ClosedEvent::class, function(ClosedEvent $e): void{
            $this->target->close();
        });
    }
    public function run(): void
    {
        $clock = Clock::create($this->systemLib);
        EventLoop::repeat(1/$this->fps, function(string $id) use ($clock): void {
            $time = $clock->restart();
            if(!$this->target->isOpen()) {
                EventLoop::cancel($id);
            }
            if($event = $this->target->pollEvent()) {
                $this->eventDispatcher->dispatch($event);
            }
            $this->eventDispatcher->dispatch(new UpdateEvent($this->target, $time));
            $this->eventDispatcher->dispatch(new RenderEvent($this->target));
        });
        EventLoop::run();
    }

    /**
     * @internal
     */
    public function add(GameObject $gameObject, int $priority): void
    {
        $this->eventDispatcher->subscribeTo(UpdateEvent::class, function(UpdateEvent $e) use ($gameObject): void {
            $gameObject->eventDispatcher->dispatch($e);
        }, $priority);
        $this->eventDispatcher->subscribeTo(RenderEvent::class, function(RenderEvent $e) use ($gameObject): void {
            $gameObject->eventDispatcher->dispatch($e);
        }, $priority);
    }
}
