<?php
namespace App\Tests\Entity;
 
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionProperty;

class UserTest extends TestCase{

    /**
     * @throws ReflectionException
     */
    public function testGetId() {
        $ID = 1;
        $user = new User();
        $property = new ReflectionProperty($user, "id");
        $property->setAccessible(true);
        $property->setValue($user, $ID);
        $this->assertEquals($ID, $user->getId());
    }

    /**
     * @throws ReflectionException
     */
    public function testSetEmail() {
        $EMAIL = "test@example.com";
        $user = new User();
        $user->setEmail($EMAIL);
        $property = new ReflectionProperty($user, "email");
        $property->setAccessible(true);
        $this->assertEquals($EMAIL, $property->getValue($user));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetEmail() {
        $EMAIL = "test@example.com";
        $user = new User();
        $property = new ReflectionProperty($user, "email");
        $property->setAccessible(true);
        $property->setValue($user, $EMAIL);
        $this->assertEquals($EMAIL, $user->getEmail());
    }

    /**
     * @throws ReflectionException
     */
    public function testSetUsername() {
        $USERNAME = "UsernameTest";
        $user = new User();
        $user->setUsername($USERNAME);
        $property = new ReflectionProperty($user, "username");
        $property->setAccessible(true);
        $this->assertEquals($USERNAME, $property->getValue($user));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetUsername() {
        $USERNAME = "UsernameTest";
        $user = new User();
        $property = new ReflectionProperty($user, "username");
        $property->setAccessible(true);
        $property->setValue($user, $USERNAME);
        $this->assertEquals($USERNAME, $user->getUsername());
    }

    /**
     * @throws ReflectionException
     */
    public function testGetUserIdentifier() {
        $USERNAME = "UsernameTest";
        $user = new User();
        $property = new ReflectionProperty($user, "username");
        $property->setAccessible(true);
        $property->setValue($user, $USERNAME);
        $this->assertEquals($USERNAME, $user->getUserIdentifier());
    }

    /**
     * @throws ReflectionException
     */
    public function testSetPassword() {
        $PASSWORD = "hvnznNIOnceomn12324lc@dcnm";
        $user = new User();
        $user->setPassword($PASSWORD);
        $property = new ReflectionProperty($user, "password");
        $property->setAccessible(true);
        $this->assertEquals($PASSWORD, $property->getValue($user));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetPassword() {
        $PASSWORD = "hvnznNIOnceomn12324lc@dcnm";
        $user = new User();
        $property = new ReflectionProperty($user, "password");
        $property->setAccessible(true);
        $property->setValue($user, $PASSWORD);
        $this->assertEquals($PASSWORD, $user->getPassword());
    }

    /**
     * @throws ReflectionException
     */
    public function testSetRoles() {
        $ROLES = ["ROLE_TEST"];
        $user = new User();
        $user->setRoles($ROLES);
        $property = new ReflectionProperty($user, "roles");
        $property->setAccessible(true);
        $this->assertEquals($ROLES, $property->getValue($user));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetRoles() {
        $ROLES = ["ROLE_USER"];
        $user = new User();
        $this->assertEquals($ROLES, $user->getRoles());
    }

    public function testGetSalt() {
        $user = new User();
        $this->assertNull($user->getSalt());
    }

    public function testEraseCredentials() {
        $user = new User();
        $user->eraseCredentials();
        $this->assertTrue(TRUE);
    }

}