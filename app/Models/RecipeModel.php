<?php

namespace App\Models;

use CodeIgniter\Model;

class RecipeModel extends Model
{
    protected $table = 'recipes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'prep_time_mins', 'cook_time_mins', 'yield'];
    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $beforeInsert = ['beforeInsert'];

    protected function beforeInsert(array $data, $attempt = 0): array
    {
        //Generate random unique 7 digit ID
        if (!isset($data['id'])) {
            $id = substr(md5(microtime()), rand(0, 26), 7);
            // Check if the ID is unique
            if ($this->where('id', $id)->first() != null) {
                // If not, try again.

                // But first, check if we've tried too many times.
                if ($attempt > 10) {
                    throw new \Exception('Unable to generate a unique ID');
                }

                // Try again.
                return $this->beforeInsert($data, $attempt++);
            }
            $data['id'] = $id;
        }

        if (!isset($data['slug']) && isset($data['title'])) {
            $data['slug'] = url_title($data['title'], '-', true);
        }

        return $data;
    }
}
