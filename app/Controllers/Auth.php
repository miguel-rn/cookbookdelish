<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class Auth extends BaseController
{
    use ResponseTrait;

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/');
    }

    public function login()
    {
        if ($this->session->get('logged_in')) {
            //javascript will refresh the page on success, fixing any issues on why this endpoint would be called...
            return $this->respond('Strange request.', 200);
        }

        $email = $this->request->getPost('email', FILTER_VALIDATE_EMAIL);
        $password = $this->request->getPost('password');

        if (!$email || !$password) {
            return $this->failNotFound('Invalid login.');
        }

        $form = $this->request->getPost();
        $userModel = new \App\Models\UserModel();

        $user = $userModel->where('email', $form['email'])->first();

        if ($user == null || !password_verify($form['password'], $user['password'])) {
            return $this->failNotFound('Invalid login.');
        }

        $savedRecipeModel = new \App\Models\SavedRecipeModel();
        $savedRecipes = $savedRecipeModel->getAllSaved($user['id']);

        $userData = [
            'id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'is_admin' => $user['is_admin'],
            'logged_in' => true
        ];
        $this->session->set($userData);

        return $this->respond(['success' => true, 'saved_recipes' => $savedRecipes], 200);
    }

    public function register()
    {
        if ($this->session->get('logged_in')) {
            //javascript will refresh the page on success, fixing any issues on why this endpoint would be called...
            return $this->respond('Strange request.', 200);
        }

        $form = $this->request->getPost();

        //make sure all fields are set
        if (!isset($form['first_name']) || !isset($form['last_name']) || !isset($form['email']) || !isset($form['password'])) {
            return $this->failNotFound('Please fill out all fields.');
        }

        $userModel = new \App\Models\UserModel();

        $user = [
            'first_name' => $form['first_name'],
            'last_name' => $form['last_name'],
            'email' => $form['email'],
            'password' => $form['password'],
            'is_admin' => 0
        ];

        if (!$userModel->insert($user, false)) {
            return $this->fail($userModel->errors());
        }

        $userData = [
            'id' => $userModel->getInsertID(),
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'is_admin' => $user['is_admin'],
            'logged_in' => true,
            'saved_recipes' => []
        ];
        $this->session->set($userData);

        return $this->respondCreated('Account created.');
    }
}
