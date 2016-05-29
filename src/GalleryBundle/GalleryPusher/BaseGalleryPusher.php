<?php

namespace GalleryBundle\GalleryPusher;


class BaseGalleryPusher
{
    /**
     * @var array
     */
    protected $callbacks;

    public function __construct()
    {

    }

    /**
     * @param string $event
     * @param callable $callback
     */
    public function addCallback($event, callable $callback)
    {
        $this->callbacks[$event] = $callback;
    }

    /**
     * @param $event
     * @return bool
     */
    public function hasCallback($event)
    {
        return array_key_exists($event, $this->callbacks);
    }

    /**
     * @param string $event
     * @throws \Exception when we have no event callback
     * @return mixed
     */
    public function triggerEvent($event)
    {
        if (!$this->hasCallback($event)) {
            throw new \Exception("Callback doesn't exist");
        }

        /**
         * @var \Closure $eventCallback
         */
        $eventCallback = $this->callbacks[$event];

        return $eventCallback->__invoke();
    }
}