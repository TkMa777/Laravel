<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        // Выполните запрос к API Rick and Morty, чтобы получить информацию о персонаже
        $response = Http::get("https://rickandmortyapi.com/api/character/{$characterId}");

        if ($response->successful()) {
            $characterData = $response->json();
            $episodeURLs = $characterData['episode'];
            Log::info('Episode URLs:', $episodeURLs);
            // Вам нужно выполнить запросы к API для каждого URL эпизода и собрать данные об эпизодах
            $episodeData = [];

            foreach ($episodeURLs as $url) {
                $episodeResponse = Http::get($url);
                Log::info('Episode Response:', ['url' => $url, 'response' => $episodeResponse->json()]);


                if ($episodeResponse->successful()) {
                    $episode = $episodeResponse->json();
                    $episodeData[] = $episode;
                }
            }

            // Верните данные об эпизодах в виде JSON
            return response()->json($episodeData);
        } else {
            return response()->json(['error' => 'Failed to fetch character episodes from the API'], 500);
        }
    }

}
