<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cocktail extends Model
{
    use HasFactory;

    protected $fillable = [
        'cocktail_id',
        'cocktail_name',
        'cocktail_image',
        'non_alcoholic'
    ];

    public function cocktailChecker($id, $userId)
    {
        $cocktail = Cocktail::where([
            ['cocktail_id', $id],
            ['user_id', $userId]
        ])->first();

        if($cocktail)
        {
            return true;
        }
        return false;
    }

    public function getUserCocktailFromDB($userId)
    {
        $cocktail = Cocktail::where([
            ['user_id', $userId]
        ])->get();

        $cocktail = $cocktail->sortBy('cocktail_name');

        return $cocktail;
    }

    public function removeUserCocktailById($cocktailId, $userId)
    {
        $removedCocktail = Cocktail::where([['user_id', $userId],['cocktail_id', $cocktailId]])->delete();
        if($removedCocktail)
        {
            return true;
        }
        return false;
    }

    public function getNonAlcoholicUserCocktailById($userId)
    {
        $cocktail = Cocktail::where([
            ['user_id', $userId],
            ['non_alcoholic', 'Non alcoholic']
        ])->get();

        $cocktail = $cocktail->sortBy('cocktail_name');

        return $cocktail;
    }

    /*
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    */
}
