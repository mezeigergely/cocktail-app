<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CocktailApiManager;

class SiteController extends Controller
{
    public function index()
    {
        $randomCocktail = $this->getRandomCocktail();
        $img = $randomCocktail[0]['cocktailImage'];
        $name = $randomCocktail[0]['cocktailName'];
        $instru = $randomCocktail[0]['cocktailInstructions'];
        $ingredients = $randomCocktail[1]['cocktailIngredientsPlusMeasures'];
        return view('welcome', compact('img', 'name', 'instru', 'ingredients'));
    }

    public function getRandomCocktail()
    {
        $cocktailApiManager = new CocktailApiManager();
        $randomCocktailFromApi = $cocktailApiManager->apiCall(config("constants.random_cocktail"));
        $randomCocktailFromApi = $this->getCocktailDetails($randomCocktailFromApi);
        return $randomCocktailFromApi;
    }

    protected function getCocktailDetails($cocktailArray) : array
    {
        $cocktailDetails = [];
        array_push($cocktailDetails, [
            "cocktailName" => $cocktailArray["strDrink"],
            "cocktailInstructions" => $cocktailArray["strInstructions"],
            "cocktailImage" => $cocktailArray["strDrinkThumb"]
        ]);
        $tempArrayIngredients = [];
        $tempArrayMeasures = [];
        foreach($cocktailArray as $subInfo => $value){
            switch(true){
                case $this->startsWith($subInfo, "strIngredient"):
                    array_push($tempArrayIngredients, $value);
                    break;
                case $this->startsWith($subInfo, "strMeasure"):
                    array_push($tempArrayMeasures, $value);
                    break;
            }
        }
        if(count($tempArrayIngredients) == count($tempArrayMeasures))
        {
            array_push($cocktailDetails, [
                'cocktailIngredientsPlusMeasures' => array_combine($tempArrayIngredients, $tempArrayMeasures)
            ]);
        }
        return $cocktailDetails;
    }

    protected function startsWith ($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }
}
