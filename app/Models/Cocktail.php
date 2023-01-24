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
        'cocktail_image'
    ];

    public function getUserCocktailFromDB($id, $userId)
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

    /*
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    */
}
