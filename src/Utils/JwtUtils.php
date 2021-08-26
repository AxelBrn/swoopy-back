<?php

namespace App\Utils;

use App\Entity\User;
use Jose\Component\Checker\AlgorithmChecker;
use Jose\Component\Checker\ClaimCheckerManager;
use Jose\Component\Checker\ExpirationTimeChecker;
use Jose\Component\Checker\HeaderCheckerManager;
use Jose\Component\Checker\IssuedAtChecker;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\JWK;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Algorithm\RS256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\JWSLoader;
use Jose\Component\Signature\JWSTokenSupport;
use Jose\Component\Signature\JWSVerifier;
use Jose\Component\Signature\Serializer\CompactSerializer;
use Jose\Component\Signature\Serializer\JWSSerializerManager;

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

    public static function verify(string $token): bool {
        $algorithmManager = new AlgorithmManager([
            new RS256(),
        ]);

        $jwsVerifier = new JWSVerifier(
            $algorithmManager
        );

        $jwk = JWKFactory::createFromKeyFile(
            self::PROJECT_DIRECTORY.$_ENV['JWT_PUBLIC_KEY'],
            $_ENV['JWT_PASSPHRASE']
        );
        $serializerManager = new JWSSerializerManager([new CompactSerializer()]);
        
        $claimCheckerManager = new ClaimCheckerManager(
            [
                new IssuedAtChecker(),
                new ExpirationTimeChecker(),
            ]
        );

        $jws = $serializerManager->unserialize($token);
        $claims = json_decode($jws->getPayload(), true);
        
        return $jwsVerifier->verifyWithKey($jws, $jwk, 0) && $claimCheckerManager->check($claims);
    }

    public static function decode($token): User {
        $serializerManager = new JWSSerializerManager([
            new CompactSerializer(),
        ]);
        $jws = $serializerManager->unserialize($token);
        $user = new User();
        $user->setUsername(json_decode($jws->getPayload())->username);
        return $user;
    }
}