<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class ProfileController extends Controller
{
    public function show($userId)
    {
        $user = (new UserModel())->find($userId);
        if (!$user) return redirect()->to('/')->with('error', 'Usuario no encontrado');

        return view('profile/show', ['user' => $user]);
    }
}