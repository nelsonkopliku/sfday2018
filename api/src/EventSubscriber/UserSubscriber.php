<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class UserSubscriber
 * @package App\EventSubscriber
 */
final class UserSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['sendPasswordReset', EventPriorities::POST_VALIDATE],
        ];
    }

    public function sendPasswordReset(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();

        if ('api_forgot_password_requests_post_collection' !== $request->attributes->get('_route')) {
            return;
        }

        $forgotPasswordRequest = $event->getControllerResult();

//        $user = $this->userManager->findOneByEmail($forgotPasswordRequest->email);
//
//        // We do nothing if the user does not exist in the database
//        if ($user) {
//            $this->userManager->requestPasswordReset($user);
//        }

        $event->setResponse(new JsonResponse(null, 204));
    }
}