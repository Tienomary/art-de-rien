<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;

class Subcategorie extends Model
{
    use HasFactory;
    protected $table = 'sub_categories';

    // Relation belongsTo pour indiquer qu'une sous-catégorie appartient à une catégorie
    public function category()
    {
        return $this->belongsTo(Categorie::class, 'category_id');
    }
}
