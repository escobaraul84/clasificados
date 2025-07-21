<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class AuthController extends Controller
{
    protected $helpers = ['form', 'url'];

    // Registro
    public function register()
    {
        return view('auth/register');
    }

    public function attemptRegister()
    {
        $rules = [
            'full_name'     => 'required|min_length[3]|max_length[120]',
            'email'         => 'required|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[6]',
            'pass_confirm'  => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->insert([
            'uuid'          => \Ramsey\Uuid\Uuid::uuid4()->getBytes(),
            'full_name'     => $this->request->getPost('full_name'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'created_at'    => Time::now()->toDateTimeString(),
            'updated_at'    => Time::now()->toDateTimeString(),
        ]);

        return redirect()->to('/login')->with('success', 'Cuenta creada. Inicia sesión.');
    }

    // Login
    public function login()
    {
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = (new UserModel())->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Credenciales inválidas.');
        }

        session()->set([
            'user_id'   => $user['id'],
            'full_name' => $user['full_name'],
            'logged_in' => true,
        ]);

        return redirect()->to('/')->with('success', 'Bienvenido ' . $user['full_name']);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Sesión cerrada.');
    }
}