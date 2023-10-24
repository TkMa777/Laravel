<?php

namespace App\Console\Commands;

use App\Models\Character;
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

    public function handle(): void
    {
        $response = Http::get('https://rickandmortyapi.com/api/character');

        if ($response->successful()) {
            $characters = $response->json()['results'];

            foreach ($characters as $character) {
                Character::create([
                    'picture_url' => $character['image'],
                    'last_name' => $character['name'],
                    'first_name' => $character['name'],
                    'species' => $character['species'],
                    'gender' => $character['gender'],
                    'status' => $character['status'],
                    'origin' => $character['origin']['name'],
                    'episodes' => count($character['episode']),
                ]);

                $this->info('Data fetched and saved successfully.');
            }
        } else {
            $this->error('Failed to fetch data from the API.');
        }
    }
}
