<template>
    <div>
        <h1 class="text-2xl font-bold">Characters</h1>
        <ul>
            <li v-for="character in characterList" :key="character.id" class="mb-4 p-4 border rounded-lg flex items-center relative">
                <img @click="showCharacterEpisodes(character)" :src="character.image" :alt="character.name" class="w-40 h-30 object-cover cursor-pointer hover:scale-105 transition-transform">
                <div class="ml-4 flex-1">
                    <p class="text-lg font-semibold">Nom: {{ character.name }}</p>
                    <div class="flex items-center mt-2">
                        <p class="text-base font-semibold">Status:</p>
                        <p class="text-base">{{ character.status }}</p>
                        <div class="ml-2" v-if="character.status === 'Alive'">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="ml-2" v-if="character.status === 'Dead'">
                            <div class="w-3 h-3 rounded-full bg-red-800"></div>
                        </div>
                        <div class="ml-2" v-if="character.status === 'unknown'">
                            <div class="w-3 h-3 rounded-full bg-gray-700"></div>
                        </div>
                    </div>
                    <p class="text-base font-semibold">Last known location:</p>
                    <p class="text-base">{{ character.location.name }}</p>
                </div>
            </li>
        </ul>

        <div v-if="showEpisodesPopup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-4 rounded-lg max-h-80 overflow-y-auto">
                <h2 class="text-xl font-bold">{{ selectedCharacter.name }} - Épisodes</h2>
                <img :src="selectedCharacter.image" alt="Character Image" class="w-40 h-40 rounded-full object-cover">


                <ul>
                    <li v-for="episode in characterEpisodes" :key="episode.id">
                        {{ episode.name }}
                    </li>
                </ul>

                <button @click="closeEpisodesPopup" class="bg-red-500 text-white p-2 rounded hover:bg-red-600">Fermer</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    props: {
        characters: Array
    },
    data() {
        return {
            showEpisodesPopup: false,
            selectedCharacter: null,
            characterEpisodes: [],
            characterName: "",
            characterStatus: "",
            characterLocation: "",
            characterList: [],
            episode: []
        };
    },
    methods: {
        loadCharacters() {
            axios.get('https://rickandmortyapi.com/api/character')
                .then(response => {
                    this.characterList = response.data.results;
                })
                .catch(error => {
                    console.log('Error in loading:', error);
                });
        },
        showCharacterEpisodes(character) {
            this.characterEpisodes = [];
            const episodeURLs = character.episode;

            const episodePromises = episodeURLs.map(url => axios.get(url));

            Promise.all(episodePromises)
                .then(episodeResponses => {
                    this.characterEpisodes = episodeResponses.map(response => response.data);

                    this.selectedCharacter = character;
                    this.showEpisodesPopup = true;
                })
                .catch(error => {
                    console.error(error);
                });
        },

        closeEpisodesPopup() {
            this.showEpisodesPopup = false;
        },
    },
    created() {
        this.loadCharacters();
    },
};
</script>
