<?php
// app/Models/CustomUser.php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class CustomUser implements AuthenticatableContract
{
    use Authenticatable;

    public $id;
    public $username;
    public $password;

    public function __construct($attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return null; // Not implemented
    }

    public function setRememberToken($value)
    {
        // Not implemented
    }

    public function getRememberTokenName()
    {
        return null; // Not implemented
    }
}