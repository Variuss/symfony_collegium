<?php

declare(strict_types=1);

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{
    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $event->setData([
            'message' => 'Login successful.',
            'roles' => $event->getUser()->getRoles(),
            'username' => $event->getUser()->getUserIdentifier()
        ]);
    }
}