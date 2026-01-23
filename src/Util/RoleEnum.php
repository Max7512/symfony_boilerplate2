<?php 

namespace App\Util;

enum RoleEnum: string {
    case ADMIN = "ROLE_ADMIN";
    case MANAGER = "ROLE_MANAGER";
    case USER = "ROLE_USER";
}