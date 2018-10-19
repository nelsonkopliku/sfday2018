<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Interfaces\DelegatableAction;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class DelegatableActionListener
 * @package App\EventSubscriber
 */
class DelegatableActionListener implements EventSubscriberInterface
{
    /**
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event) : void
    {
        $data = $event->getControllerResult();
        $controller = $event->getRequest()->get('_controller');

        if (null === $data && is_a($controller, DelegatableAction::class, true)) {
            $event->setResponse(new Response('', Response::HTTP_ACCEPTED));
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::VIEW    => [
                'onKernelView', EventPriorities::PRE_VALIDATE
            ]
        ];
    }
}