<?php

namespace App\Models;

use CodeIgniter\Model;

class SavedRecipeModel extends Model
{
    protected $table = 'user_saved';
    protected $allowedFields = ['user_id', 'recipe_id'];

    public function getAllSaved($userId): array
    {
        $recipeIds = $this->where('user_id', $userId)->findColumn('recipe_id');
        return $recipeIds ? $recipeIds : [];
    }
}
