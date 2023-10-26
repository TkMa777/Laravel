<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Character;
use App\Models\Episode;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchApi extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commande de récupération des données depuis l\'API';

    /**
     * Execute the console command.
     */

    /*
     *   nous obtenons l'adresse URL,
     *   et créons une boucle dans la base de données pour chaque personnage de l'API.
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $characterResponse = Http::get('https://rickandmortyapi.com/api/character');
        $episodeResponse = Http::get('https://rickandmortyapi.com/api/episode');
        $locationResponse = Http::get('https://rickandmortyapi.com/api/location');

        if ($characterResponse->successful() && $episodeResponse->successful() && $locationResponse->successful()) {
            $characterData = $characterResponse->json();
            $episodeData = $episodeResponse->json();
            $locationData = $locationResponse->json();

            foreach ($characterData['results'] as $characterData) {
                Character::create([
                    'id' => $characterData['id'],
                    'name' => $characterData['name'],
                    'status' => $characterData['status'],
                    'species' => $characterData['species'],
                    'type' => $characterData['type'],
                    'gender' => $characterData['gender'],
                    'origin' => $characterData['origin'],
                    'location' => $characterData['location'],
                    'image' => $characterData['image'],
                    'episodes' => $characterData['episodes'],
                    'url' => $characterData['url'],
                    'created' => $characterData['created'],
                ]);
            }

            foreach ($episodeData['results'] as $episodeData) {
                Episode::create([
                    'id' => $episodeData['id'],
                    'name' => $episodeData['name'],
                    'air_date' => $episodeData['air_date'],
                    'episode' => $episodeData['episode'],
                    'characters' => json_encode($episodeData['characters']),
                    'url' => $episodeData['url'],
                    'created' => $episodeData['created'],
                ]);
            }


            foreach ($locationData['results'] as $locationData) {
                Location::create([
                    'id' => $locationData['id'],
                    'name' => $locationData['name'],
                    'type' => $locationData['type'],
                    'dimension' => $locationData['dimension'],
                    'residents' => json_encode($locationData['residents']),
                    'url' => $locationData['url'],
                    'created' => $locationData['created'],
                ]);
            }

            $this->info('Data has been fetched and saved.');
        } else {
            $this->error('Failed to fetch data from the API.');
        }
    }
}
