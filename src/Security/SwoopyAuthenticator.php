<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Exception\InvalidTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\JWTAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class SwoopyAuthenticator extends JWTAuthenticator
{
    public function doAuthenticate(Request $request): Passport
    {
        $passport = parent::doAuthenticate($request);
        $payload = $passport->getAttribute('payload');
        if (empty($payload['type']) || $payload['type'] !== 'access_token') {
            throw new InvalidTokenException('Invalid JWT Token.');
        }
        return $passport;
    }
}