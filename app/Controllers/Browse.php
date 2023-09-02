<?php

namespace App\Controllers;

class Browse extends BaseController
{
    public function index(): string
    {
        $this->data['page_title'] = 'Explore Recipes';

        $categoryModel = new \App\Models\CategoryModel();

        //Fetch categories from the database
        $allCategories = $categoryModel->findAll();
        //Loop through the categories and add all parent categories (parent_id==null) to the data array. If the category has a parent, add it to the children array of the parent category.
        foreach ($allCategories as $category) {
            if ($category['parent_id'] == null) {
                $this->data['categories'][$category['id']] = [
                    'id' => $category['id'],
                    'name' => $category['name'],
                    'children' => []
                ];
            } else {
                $this->data['categories'][$category['parent_id']]['children'][] = [
                    'child_id' => $category['id'],
                    'child_name' => $category['name']
                ];
            }
        }

        $recipeModel = new \App\Models\RecipeModel();

        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $this->data['recipes'] = $recipeModel->like('title', $_GET['q'])->findAll(12, 0);
        } elseif (isset($_GET['category']) && is_numeric($_GET['category'])) {
            $category_id = $_GET['category'];
            $this->data['recipes'] = $recipeModel->where('category_id', $category_id)->findAll(12, 0);
        } else {
            //TODO: cache seed, regenerate every 24 hours
            $seed = 2129;
            $this->data['recipes'] = $recipeModel->getRandomRecipes(12, 0, $seed);
        }

        $view = view('browse');
        //loading the view prior to passing it to the parser for rendering is required so that the parser works properly.
        //Just passing the view to the parser via the render($view) function will not work as expected.
        return $this->parser->setData($this->data)->renderString($view);
    }
}
