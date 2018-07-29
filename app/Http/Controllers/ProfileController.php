<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()->paginate(10);

        return view('profiles.show', [
            'profileUser' => $user,
            'posts'       => $posts,
        ]);

    }
}
