<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;


/*
 * Depuis mon base de données,
 * je recoupere la liste des personnages de sexe féminin
 * et de l’espèce humaine que vous passerez à la vue blade
 */

class CharactersController extends Controller
{
    public function index()
    {
        $femaleCharacters = Character::where('gender', 'Female')
            -> where ('species', 'Human')
            -> get();
        return view('characters' , ['characters' => $femaleCharacters]);
    }
}
