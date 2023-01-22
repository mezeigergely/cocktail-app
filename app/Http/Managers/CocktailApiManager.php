<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class CocktailApiManager extends Model
{
    public function apiCall($endpoint, $cocktailName = []) : array
    {
        $apiUrl = config('constants.api_url').$endpoint;
        if(!empty($cocktailName)){
            $apiUrl = config('constants.api_url').$endpoint.$cocktailName;
        }
        $theCocktailDbResponse = Http::get($apiUrl);
        try{
            $dataResponse = json_decode($theCocktailDbResponse, true);
        }
        catch (Exception $e)
        {
            Log::error('Api call error!'.' '.$e);
            return redirect('/');
        }
        if($endpoint == "filter.php?a=Non_Alcoholic")
        {
            return $dataResponse;
        }
        else{
            $cocktailFromApi = (!empty($dataResponse)) ? $dataResponse["drinks"][0] : [];
            return $cocktailFromApi ?? [];
        }
    }
}
