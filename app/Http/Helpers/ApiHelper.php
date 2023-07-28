<?php

namespace App\Helpers;



use App\Models\User;

function getUserByToken($token)
{
    return User::where('access_token', $token)->first();
}

function clearToken($param)
{
    return str_replace('Bearer ','',$param);
}
