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

        $page = isset($_GET['p']) ? (int) $_GET['p'] : null;
        // because CodeIgniter 4's pagination documentation is currently, as of Sept 6 2023, poor and unclear.
        if (!$page || $page < 1) {
            $page = 1;
        }
        $limit = 12;
        $offset = ($page - 1) * $limit;

        //TODO: cache seed, regenerate every 24 hours
        $seed = 2129;

        $search = isset($_GET['q']) ? $_GET['q'] : null;
        $category_id = isset($_GET['cat']) ? (int) $_GET['cat'] : null;

        if ($search && $search != '') {
            $this->data['recipes'] = $recipeModel->like('title', $search)->findAll($limit, $offset);
            $total = $recipeModel->like('title', $search)->countAllResults();
            $this->data['search_query'] = $search;
        } elseif ($category_id && $category_id > 0) {
            $category_id = $_GET['cat'];
            // use builder to join categories and recipes table to find recipes via category_id
            $this->data['recipes'] = $recipeModel->join('recipe_categories', 'recipe_categories.recipe_id = recipes.id')->where('category_id', $category_id)->orderBy("RAND($seed)")->findAll($limit, $offset);
            $total = $recipeModel->join('recipe_categories', 'recipe_categories.recipe_id = recipes.id')->where('category_id', $category_id)->countAllResults();
        } else {
            $this->data['recipes'] = $recipeModel->orderBy("RAND($seed)")->findAll($limit, $offset);
            $total = $recipeModel->countAllResults();
        }

        // insert all GET data into the base link
        $pageBaseLink = http_build_query($_GET);

        $this->data['previousPage'] = null;
        $this->data['nextPage'] = null;

        if ($page > 1) {
            $previousPage = $page - 1;
            if (strpos($pageBaseLink, 'p=') !== false) {
                //if it does, replace it with current page number
                $previousPageLink = preg_replace('/p=[0-9]+/', 'p=' . $previousPage, $pageBaseLink);
            } else {
                //if it doesn't, append the current page number to the base link
                $previousPageLink = $pageBaseLink . '&p=' . $previousPage;
            }
            $this->data['previousPage'] = $previousPageLink;
        }

        if ($page < ceil($total / $limit)) {
            $nextPage = $page + 1;
            if (strpos($pageBaseLink, 'p=') !== false) {
                //if it does, replace it with current page number
                $nextPageLink = preg_replace('/p=[0-9]+/', 'p=' . $nextPage, $pageBaseLink);
            } else {
                //if it doesn't, append the current page number to the base link
                $nextPageLink = $pageBaseLink . '&p=' . $nextPage;
            }
            $this->data['nextPage'] = $nextPageLink;
        }

        $view = view('browse');
        //loading the view prior to passing it to the parser for rendering is required so that the parser works properly.
        //Just passing the view to the parser via the render($view) function will not work as expected.
        return $this->parser->setData($this->data)->renderString($view);
    }
}
