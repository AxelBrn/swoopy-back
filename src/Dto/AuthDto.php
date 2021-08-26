<?php

namespace App\Dto;

use OpenApi\Annotations as OA;

class AuthDto extends AbstractDto {

    /**
     * @OA\Property(type="string", maxLength=255, example="username")
     */
    public string $username = '';
    
    /**
     * @OA\Property(type="string", maxLength=255, example="password")
     */
    public string $password = '';

    protected function buildByRequest(): void {
        $object = $this->getRequestContent();
        $this->username = $object['username'];
        $this->password = $object['password'];
    }


}