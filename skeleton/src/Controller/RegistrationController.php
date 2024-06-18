<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

#[Route('/api', name: 'api_')]
class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'api_register', methods: 'post')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        UserRepository $userRepository,
        Security $security
    ): JsonResponse
    {
        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->json(['message' => 'Access denied.'], 403);
        }

        if ($request->headers->get('Content-Type') != 'application/json') {
            return $this->json(
                [
                    'message' => 'Content type ' . $request->headers->get('Content-Type') . ' not supported.'
                ], 415);
        }

        $decoded = json_decode($request->getContent());
        $email = $decoded->email;
        $plaintextPassword = $decoded->password;

        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setEmail($email);
        $user->setUsername($email);
        $user->setRoles(['ROLE_STUDENT']);
        $userRepository->save($user);

        return $this->json(['message' => 'Registered Successfully']);
    }
}