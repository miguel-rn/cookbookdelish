<?php

namespace App\Models;

use CodeIgniter\Model;

class RecipeStepsModel extends Model
{
    protected $table = 'recipe_steps';
    protected $allowedFields = ['recipe_id', 'step', 'body'];

    public function getStepsByRecipeId($recipe_id): array
    {
        return $this->where('recipe_id', $recipe_id)->findAll();
    }
}
