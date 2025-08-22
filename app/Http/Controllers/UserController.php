<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // bisa filter sesuai kebutuhan, misal hanya active users
        return response()->json(User::all());
    }
}
