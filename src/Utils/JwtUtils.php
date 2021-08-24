<?php

namespace App\Utils;

use App\Entity\User;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\JWK;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Algorithm\RS256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;

class JwtUtils {
    private const PROJECT_DIRECTORY = '..'.DIRECTORY_SEPARATOR;

    public static function generateAccessToken(User $user) {
        $algorithmManager = new AlgorithmManager([
            new RS256(),
        ]);

        $jwk = JWKFactory::createFromKeyFile(
            self::PROJECT_DIRECTORY.$_ENV['JWT_SECRET_KEY'],
            $_ENV['JWT_PASSPHRASE'],
            [
                'use' => 'sig',
            ]
        );

        $jwsBuilder = new JWSBuilder($algorithmManager);

        $payload = json_encode([
            'iat' => time(),
            'exp' => time() + 3600,
            'iss' => 'Swoopy API',
            'aud' => 'Swoopy',
            'username' => $user->getUserIdentifier(),
        ]);
        
        $jws = $jwsBuilder
            ->create()                               // We want to create a new JWS
            ->withPayload($payload)                  // We set the payload
            ->addSignature($jwk, ['alg' => 'RS256']) // We add a signature with a simple protected header
            ->build();

        $serializer = new CompactSerializer(); // The serializer

        return $serializer->serialize($jws, 0);
    }
}