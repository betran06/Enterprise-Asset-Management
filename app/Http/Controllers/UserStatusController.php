<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserStatusController extends Controller
{
    public function index()
    {
        $users = User::with('role')
            ->orderBy('name')
            ->get()
            ->map(function ($user) {
                $user->is_online = Cache::has('user-is-online-' . $user->id);
                return $user;
            });

        return view('users.status', compact('users'));
    }
}
