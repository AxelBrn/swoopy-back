<?php

namespace App\Dto;

use OpenApi\Annotations as OA;

class UserDto extends AbstractDto
{

    /**
     * @OA\Property(type="string", maxLength=180, example="example@domain.com")
     */
    public string $email = '';

    /**
     * @OA\Property(type="string", maxLength=25, example="username")
     */
    public string $username = '';

    /**
     * @OA\Property(type="string", maxLength=255, example="password")
     */
    public string $password = '';



    protected function buildByRequest(): void
    {
        $object = $this->getRequestContent();
        $this->email = $object['email'];
        $this->username = $object['username'];
        $this->password = $object['password'];
    }
}
