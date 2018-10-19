<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use Predis\ClientInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CatalogCreatedSubscriber
 * @package App\EventSubscriber
 */
class CatalogCreatedSubscriber implements EventSubscriberInterface
{

    public const DEFINITION_KEY  = '_publish_on_create';

    public const UNKNOWN_CHANNEL = 'unknown_channel';

    /**
     * @var ClientInterface
     */
    private $redisClient;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * CatalogCreatedSubscriber constructor.
     * @param ClientInterface $redisClient
     * @param SerializerInterface $serializer
     */
    public function __construct(ClientInterface $redisClient, SerializerInterface $serializer)
    {
        $this->redisClient = $redisClient;
        $this->serializer  = $serializer;
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     */
    public function onCatalogCreated(GetResponseForControllerResultEvent $event): void
    {
        if ($event->hasResponse()) {
            return;
        }

        $request = $event->getRequest();

        if ($request->attributes->has(static::DEFINITION_KEY)) {
            $this->redisClient->publish(
                $request->attributes->get(static::DEFINITION_KEY)['channel'] ?? static::UNKNOWN_CHANNEL,
                $this->serializer->serialize($event->getControllerResult(), 'json')
            );
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::VIEW => [
                'onCatalogCreated', EventPriorities::POST_WRITE
            ]
        ];
    }
}