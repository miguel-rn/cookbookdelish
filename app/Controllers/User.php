<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class User extends BaseController
{
    use ResponseTrait;

    public function saved()
    {
        $this->data['page_title'] = 'Saved Recipes';

        //fetch saved recipes from the database
        $savedRecipeModel = new \App\Models\SavedRecipeModel();
        $savedRecipes = $savedRecipeModel->where('user_id', $this->session->get('id'))->findAll();

        if (empty($savedRecipes)) {
            $this->data['recipes'] = [];
        } else {
            $recipeModel = new \App\Models\RecipeModel();
            $this->data['recipes'] = $recipeModel->whereIn('id', array_column($savedRecipes, 'recipe_id'))->findAll();
        }

        $view = view('saved');
        //loading the view prior to passing it to the parser for rendering is required so that the parser works properly.
        //Just passing the view to the parser via the render($view) function will not work as expected.
        return $this->parser->setData($this->data)->renderString($view);
    }

    public function save()
    {
        $recipeId = (string) $this->request->getPost('recipe_id');
        if (!$recipeId || !ctype_alnum($recipeId)) {
            return $this->fail('Invalid recipe id.');
        }

        $userId = $this->session->get('id');

        $savedRecipes = isset($_COOKIE['saved_recipes']) ? json_decode($_COOKIE['saved_recipes']) : [];

        //check if the recipe is already saved
        $savedRecipeModel = new \App\Models\SavedRecipeModel();
        if ($savedRecipeModel->where('recipe_id', $recipeId)->where('user_id', $userId)->countAllResults() > 0) {
            //delete it
            if (!$savedRecipeModel->where('recipe_id', $recipeId)->where('user_id', $userId)->delete()) {
                return $this->fail($savedRecipeModel->errors());
            }
            //remove the recipe from saved_recipes cookie
            $savedRecipes = array_diff($savedRecipes, [$recipeId]);
            setcookie('saved_recipes', json_encode($savedRecipes), time() + (86400 * 30), '/');
            return $this->respondDeleted('Recipe unsaved.');
        }

        //check if recipe exists
        $recipeModel = new \App\Models\RecipeModel();
        if (!$recipeModel->find($recipeId)) {
            return $this->failNotFound('Recipe not found.');
        }

        //save it
        $savedRecipeModel->insert(['recipe_id' => $recipeId, 'user_id' => $userId]);
        //add the recipe to saved_recipes cookie
        $savedRecipes[] = $recipeId;

        setcookie('saved_recipes', json_encode($savedRecipes), time() + (86400 * 30), '/');
        return $this->respondCreated('Recipe saved.');
    }

    public function account()
    {
        $this->data['page_title'] = 'Account Settings';
        $view = view('account');
        //loading the view prior to passing it to the parser for rendering is required so that the parser works properly.
        //Just passing the view to the parser via the render($view) function will not work as expected.
        return $this->parser->setData($this->data)->renderString($view);
    }

    public function updateAccount()
    {
        $form = $this->request->getPost();

        $userModel = new \App\Models\UserModel();
        $userId = $this->session->get('id');

        if (isset($form['password']) && isset($form['new_password'])) {
            $user = $userModel->find($userId);
            if (!password_verify($form['password'], $user['password'])) {
                return $this->failForbidden('Invalid password.');
            }

            if (!$userModel->update($userId, ['password' => $form['new_password']], false)) {
                return $this->fail($userModel->errors());
            }

            return $this->respondUpdated('Password updated.');
        }

        if (!isset($form['first_name']) || !isset($form['last_name']) || !isset($form['email'])) {
            return $this->fail('Please fill out all fields.');
        }

        $updateData = [
            'id' => $userId,
            'first_name' => $form['first_name'],
            'last_name' => $form['last_name'],
            'email' => $form['email']
        ];

        if ($userModel->update($userId, $updateData) === false) {
            return $this->fail($userModel->errors());
        }

        $this->session->set('first_name', $updateData['first_name']);
        $this->session->set('last_name', $updateData['last_name']);
        $this->session->set('email', $updateData['email']);

        return $this->respondUpdated('Account updated.');
    }
}
