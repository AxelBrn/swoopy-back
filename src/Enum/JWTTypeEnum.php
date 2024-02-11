<?php

namespace App\Enum;

enum JWTTypeEnum: string {
    case JWT_TYPE_ACCESS_TOKEN = 'access_token';

    case JWT_TYPE_REFRESH_TOKEN = 'refresh_token';
}