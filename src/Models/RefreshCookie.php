<?php

namespace App\Models;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Utils\JwtUtils;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Axel Brionne
 */
class RefreshCookie
{

    private ?User $user;
    private $token = '';

    public function __construct(RequestStack $stack, UserRepository $userRepository)
    {
        $this->user = null;
        $request = $stack->getCurrentRequest();
        $refreshToken = $request->cookies->get('refreshToken');
        if ($refreshToken !== null) {
            $userTemp = JwtUtils::decode($refreshToken);
            $this->user = $userRepository->findOneBy(['username' => $userTemp->getUserIdentifier()]);
            $this->token = $refreshToken;
        }
    }


    /**
     * Get the value of user
     * @return  User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Check the validity of Jwt token
     * @return bool
     */
    public function isValid(): bool
    {
        return JwtUtils::verify($this->token);
    }
}
