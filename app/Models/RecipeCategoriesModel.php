<?php

namespace App\Models;

use CodeIgniter\Model;

class RecipeCategoriesModel extends Model
{
    protected $table = 'recipe_categories';
    protected $allowedFields = ['recipe_id', 'ingredient_desc'];

    public function getIngredientsByRecipeId($recipe_id): array
    {
        return $this->where('recipe_id', $recipe_id)->findAll();
    }
}
