<?php

namespace App\Http\Controllers;

use App\Models\Cocktail;
use Illuminate\Http\Request;
use App\Models\CocktailApiManager;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function index()
    {
        $randomCocktail = $this->getRandomCocktail();
        $img = $randomCocktail[0]['cocktailImage'];
        $name = $randomCocktail[0]['cocktailName'];
        return view('welcome', compact('img', 'name'));
    }

    public function getRandomCocktail()
    {
        $cocktailApiManager = new CocktailApiManager();
        $randomCocktailFromApi = $cocktailApiManager->apiCall(config("constants.random_cocktail"));
        $randomCocktailFromApi = $this->getCocktailDetails($randomCocktailFromApi);
        return $randomCocktailFromApi;
    }

    public function getCocktailByName(Request $request)
    {
        $cocktailApiManager = new CocktailApiManager();
        $cocktailFromApi = $cocktailApiManager->apiCall(config("constants.search_by_name").$request->name);
        if(!empty($cocktailFromApi)){
            $cocktailFromApi = $this->getCocktailDetails($cocktailFromApi);
        }
        $id = $cocktailFromApi[0]['cocktailID'];
        $img = $cocktailFromApi[0]['cocktailImage'];
        $name = $cocktailFromApi[0]['cocktailName'];
        $instru = $cocktailFromApi[0]['cocktailInstructions'];
        $ingredients = $cocktailFromApi[1]['cocktailIngredientsPlusMeasures'];
        $glass = $cocktailFromApi[0]['cocktailGlass'];
        return view('cocktail', compact('id', 'img', 'name', 'instru', 'ingredients', 'glass'));
    }

    public function searchByName()
    {
        try{
            $cocktailApiManager = new CocktailApiManager();
            $cocktailsFromApi = $cocktailApiManager->getCocktailByName($_GET['search']);
            $cocktailArray = [];
            foreach($cocktailsFromApi as $cocktails)
            {
                foreach($cocktails as $cocktail)
                {
                    array_push($cocktailArray, [
                        "cocktailName" => $cocktail["strDrink"],
                        "cocktailImage" => $cocktail["strDrinkThumb"],
                    ]);
                }
            }
            return view('cocktails', compact('cocktailArray'));
        }
        catch(Exception $e){
            Log::error('Cocktail serach by name error!'.' '.$e);
            return Redirect::back()->withErrors(['error' => 'Invalid input!']);
        }

    }

    public function saveFavCocktail(Request $request)
    {
        $cocktailApiManager = new CocktailApiManager();
        $cocktailsFromApi = $cocktailApiManager->apiCall(config("constants.search_by_id").$request->saveCocktail);
        try{
            if($cocktailsFromApi){
                $cocktail = new Cocktail();
                $cocktailChecker = $cocktail->getUserCocktailFromDB($cocktailsFromApi["idDrink"], Auth::id());
                if($cocktailChecker)
                {
                    return Redirect::back()->withErrors(['error' => 'This cocktail is already added!']);
                }
                else{
                    $cocktail->user_id = Auth::id();
                    $cocktail->cocktail_id = $cocktailsFromApi["idDrink"];
                    $cocktail->cocktail_name = $cocktailsFromApi["strDrink"];
                    $cocktail->cocktail_image = $cocktailsFromApi["strDrinkThumb"];
                    $cocktail->save();
                    return redirect()->back()->with('message', 'This cocktail is added!');
                }

            }
        }
        catch(Exception $e){
            Log::error('Cocktail save error!'.' '.$e);
            return Redirect::back()->withErrors(['error' => 'Error while saving']);
        }
    }

    public function profile()
    {
        return view('profile.profile');
    }

    public function advancedSearchView()
    {
        return view('profile.advancedSearch');
    }

    protected function getCocktailDetails($cocktailArray) : array
    {
        $cocktailDetails = [];
        array_push($cocktailDetails, [
            "cocktailID" => $cocktailArray["idDrink"],
            "cocktailName" => $cocktailArray["strDrink"],
            "cocktailInstructions" => $cocktailArray["strInstructions"],
            "cocktailImage" => $cocktailArray["strDrinkThumb"],
            "cocktailGlass" => $cocktailArray["strGlass"]
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
