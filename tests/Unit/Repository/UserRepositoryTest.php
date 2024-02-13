<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    /**
     * @dataProvider loadUserByIdentifierProvider
     */
    public function testLoadUserByIdentifier(bool $expectedUserInstance, string $emailOrUsername): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $userRepo = $container->get(UserRepository::class);
        $result = $userRepo->loadUserByIdentifier($emailOrUsername);
        $this->assertTrue($expectedUserInstance ? $result instanceof User : null === $result);
    }

    public function loadUserByIdentifierProvider(): array
    {
        return json_decode(file_get_contents(__DIR__.'/data/user/loadUserByIdentifier.json'), true);
    }
}
