<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

   protected $fillable = [
    'winner',
    'loser'
    ];

   public static function expected($Rb, $Ra){

   	return 1 / (1 + pow(10, ($Rb - $Ra) / 400));
 
   }


   public static function win($score, $expected, $k = 24){

   	return $score + $k * (1 - $expected);

   }


   public static function loss($score, $expected, $k = 24){

   	return $score + $k * (0 - $expected);

   }


   public static function rank($score, $losses, $wins){

   	if(($score == 0) || ($losses == 0) || ($wins == 0)){
   		return 0;
   	}
   	return 1700 - $score;
   
   }
}
