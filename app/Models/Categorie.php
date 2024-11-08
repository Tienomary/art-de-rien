<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subcategorie;

class Categorie extends Model
{
    use HasFactory;
    protected $table = 'categories';

    // Relation hasMany pour lier les sous-catégories à la catégorie
    public function subCategories()
    {
        return $this->hasMany(Subcategorie::class, 'category_id');
    }
}
