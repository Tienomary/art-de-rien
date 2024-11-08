<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\Categorie;
use App\Models\Subcategorie;

class Creation extends Model
{
    use HasFactory;
    protected $table = 'creation';
    protected $fillable = ['name', 'description', 'images', 'sub_categories'];

    public function getImagesAttribute()
    {
        $images = json_decode($this->attributes['images'], true);
        $images_obj = [];
        foreach ($images as $image) {
            array_push($images_obj, Image::find($image));
        }
        return $images_obj;
    }

    public function getSubCategoriesAttributeok()
    {
        $sub_categories =json_decode($this->attributes['sub_categories'], true);
        $sub_categories_obj = [];
        foreach ($sub_categories as $key) {
            array_push($sub_categories_obj, Subcategorie::find($key));
        }
        return $sub_categories_obj;
    }
}
