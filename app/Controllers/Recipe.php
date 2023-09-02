<?php

namespace App\Controllers;

class Recipe extends BaseController
{
    public function saveRecipe()
    {
    }

    public function viewRecipe($id, $slug)
    {
        if (strlen($id) != 7 || !ctype_alnum($id)) {
            return throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        //Fetch the recipe from the database
        $recipeModel = new \App\Models\RecipeModel();
        $recipe = $recipeModel->find($id);

        //Check if exists
        if ($recipe == null) {
            return throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $recipeSlug = $recipe['slug'];

        //Check if the slug is correct
        if ($recipeSlug != $slug) {
            return redirect()->to('/recipe/' . $id . '/' . $recipeSlug);
        }

        $this->data['page_title'] = $recipe['title'];
        $this->data['recipe_description'] = $recipe['description'];
        $this->data['prep_time'] = $this->format_minutes($recipe['prep_time_mins']);
        $this->data['cook_time'] = $this->format_minutes($recipe['cook_time_mins']);
        $this->data['yield'] = $recipe['yield'];

        //Fetch the recipe's steps from the database
        $recipeStepsModel = new \App\Models\RecipeStepsModel();
        $this->data['recipe_steps'] = $recipeStepsModel->where('recipe_id', $id)->orderBy('step', 'ASC')->findAll();

        //Fetch the recipe's ingredients from the database
        $recipeIngredientsModel = new \App\Models\RecipeIngredientsModel();
        $this->data['recipe_ingredients'] = $recipeIngredientsModel->where('recipe_id', $id)->findAll();

        $view = view('recipe');
        //loading the view prior to passing it to the parser for rendering is required so that the parser works properly.
        //Just passing the view to the parser via the render($view) function will not work as expected.
        return $this->parser->setData($this->data)->renderString($view);
    }

    protected function format_minutes($minutes)
    {
        $hours = floor($minutes / 60);
        $remaining_minutes = $minutes % 60;

        $formatted_time = '';

        if ($hours > 0) {
            $formatted_time .= $hours . ' hr';
            if ($hours > 1) {
                $formatted_time .= 's';
            }
        }

        if ($remaining_minutes > 0) {
            if ($hours > 0) {
                $formatted_time .= ' ';
            }
            $formatted_time .= $remaining_minutes . ' min';
        }

        return $formatted_time;
    }
}
