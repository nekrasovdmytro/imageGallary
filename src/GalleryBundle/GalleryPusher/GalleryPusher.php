<?php

namespace GalleryBundle\GalleryPusher;

use Symfony\Component\DependencyInjection\ContainerInterface;

class GalleryPusher
{
    protected $pusher;

    const GALLERY_STATIC_CHANNEL = 'gallery_channel';

    public function __construct(ContainerInterface $container, array $options = null)
    {
        if (null === $options) {
            $options = [
                'encrypted' => true
            ];
        }

        $this->pusher = new \Pusher(
            $container->getParameter('pusher_auth_key'),
            $container->getParameter('pusher_secret'),
            $container->getParameter('pusher_app_id'),
            $options
        );
    }

    public function getPusher()
    {
        return $this->pusher;
    }

    public function triggerMessage($event, array $data)
    {
        $this->getPusher()->trigger(static::GALLERY_STATIC_CHANNEL, $event, $data);
    }
}