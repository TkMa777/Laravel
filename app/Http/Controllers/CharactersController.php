<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Support\Facades\Http;

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

    public function getCharacterEpisodes($characterId)
    {
        $character = Character::where('id', $characterId)->first();

        if (!$character) {
            return response()->json(['error' => 'Character not found'], 404);
        }

        $episodeIds = json_decode($character->episodes);

        $episodes = [];

        foreach ($episodeIds as $episodeId) {
            $response = Http::get("https://rickandmortyapi.com/api/episode/{$episodeId}");
            if ($response->successful()) {
                $episodeData = $response->json();
                $episodes[] = $episodeData;
            }
        }

        return view('character_episodes', ['character' => $character, 'episodes' => $episodes]);
    }



}
