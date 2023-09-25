<?php

namespace iggyvolz\iggyengine;

use iggyvolz\SFML\Graphics\RenderWindow;
use iggyvolz\SFML\Sfml;
use iggyvolz\SFML\System\Clock;
use iggyvolz\SFML\Window\Event\ClosedEvent;
use League\Event\EventDispatcher;
use League\Event\ListenerPriority;
use League\Event\ListenerRegistry;
use League\Event\ListenerSubscriber;
use Revolt\EventLoop;

final readonly class Stage implements ListenerRegistry
{
    private EventDispatcher $eventDispatcher;

    public function __construct(
        public Sfml         $sfml,
        public RenderWindow $target,
        public int          $fps,
    )
    {
        $this->eventDispatcher = new EventDispatcher();
        $this->eventDispatcher->subscribeTo(ClosedEvent::class, function(): void{
            $this->target->close();
        });
    }
    public static function createWindow(Sfml $sfml, string $title, int $fps = 60): self
    {
        return new self($sfml, RenderWindow::create($sfml, $title), $fps);
    }
    public function run(): void
    {
        $clock = Clock::create($this->sfml);
        EventLoop::repeat(1/$this->fps, function(string $id) use ($clock): void {
            $time = $clock->restart();
            if(!$this->target->isOpen()) {
                EventLoop::cancel($id);
            }
            while($event = $this->target->pollEvent()) {
                $this->eventDispatcher->dispatch($event);
            }
            $this->eventDispatcher->dispatch(new UpdateEvent($time));
            $this->target->clear();
            $this->eventDispatcher->dispatch(new RenderEvent($this->target));
            $this->target->display();
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

    public function subscribeTo(string $event, callable $listener, int $priority = ListenerPriority::NORMAL): void
    {
        $this->eventDispatcher->subscribeTo($event, $listener, $priority);
    }

    public function subscribeOnceTo(string $event, callable $listener, int $priority = ListenerPriority::NORMAL): void
    {
        $this->eventDispatcher->subscribeOnceTo($event, $listener, $priority);
    }

    public function subscribeListenersFrom(ListenerSubscriber $subscriber): void
    {
        $this->eventDispatcher->subscribeListenersFrom($subscriber);
    }
}
