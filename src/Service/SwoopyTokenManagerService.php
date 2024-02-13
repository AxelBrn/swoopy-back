<?php

namespace App\Service;

use App\Entity\User;
use App\Enum\JWTTypeEnum;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\ExpiredTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\InvalidPayloadException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\InvalidTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Security\Core\User\UserInterface;

class SwoopyTokenManagerService
{
    private JWTTokenManagerInterface $JWTManager;
    private UserRepository $userRepository;

    public function __construct(JWTTokenManagerInterface $jWTTokenManagerInterface, UserRepository $userRepository)
    {
        $this->JWTManager = $jWTTokenManagerInterface;
        $this->userRepository = $userRepository;
    }

    public function createAccessToken(UserInterface $user): string
    {
        return $this->JWTManager->create($user);
    }

    public function createRefreshTokenCookie(UserInterface $user): Cookie
    {
        $date = new \DateTime();
        $interval = \DateInterval::createFromDateString($_ENV['JWT_REFRESH_TOKEN_TTL_IN_DAY'].' day');
        if (false !== $interval) {
            $date->add($interval);
        }
        $refreshToken = $this->JWTManager->createFromPayload($user, [
            'type' => JWTTypeEnum::JWT_TYPE_REFRESH_TOKEN->value,
            'exp' => $date->getTimestamp(),
        ]);

        return Cookie::create('refresh_token', $refreshToken, $date->getTimestamp());
    }

    /**
     * @param array<string, int|string> $payload
     *
     * @return array<string, int|string|null>
     */
    public function modifyTokenPayload(UserInterface $user, array $payload): array
    {
        $payload['iss'] = 'Swoopy';
        if (!isset($payload['type'])) {
            $payload['type'] = JWTTypeEnum::JWT_TYPE_ACCESS_TOKEN->value;
        }
        if ($user instanceof User) {
            $payload['id'] = $user->getId();
        }
        unset($payload['roles']);

        return $payload;
    }

    public function getUserFromRefreshToken(string $refreshToken): ?UserInterface
    {
        try {
            if (!$payload = $this->JWTManager->parse($refreshToken)) {
                throw new InvalidTokenException('Invalid JWT Refresh Token');
            }
        } catch (JWTDecodeFailureException $e) {
            if (JWTDecodeFailureException::EXPIRED_TOKEN === $e->getReason()) {
                throw new ExpiredTokenException('Token is expired');
            }
            throw new InvalidTokenException('Invalid JWT Refresh Token', 0, $e);
        }
        $idClaim = $this->JWTManager->getUserIdClaim();
        if (!isset($payload[$idClaim])) {
            throw new InvalidPayloadException($idClaim);
        } elseif (!isset($payload['type']) || $payload['type'] !== JWTTypeEnum::JWT_TYPE_REFRESH_TOKEN->value) {
            throw new InvalidPayloadException('type');
        }

        return $this->userRepository->loadUserByIdentifier($payload[$idClaim]);
    }
}
