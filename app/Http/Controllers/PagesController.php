<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;

class PagesController extends Controller
{
    public function getAllUsers(): View
    {
        return view('users', ['users' => User::all()]);
    }

    public function about()
    {
        $a = 3;
        $b = 5;
        $sum = $a + $b;
        return "Sum is $sum";
    }
}
