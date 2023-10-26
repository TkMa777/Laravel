<template>
    <div>
        <h1 class="text-2xl font-bold">Characters</h1>
        <ul>
            <li v-for="character in characterList" :key="character.id" class="mb-4 p-4 border rounded-lg">
                <img :src="character.image" :alt="character.name" class="w-20 h-20 rounded-full object-cover">
                <p class="text-lg font-semibold">Nom: {{ character.name }}</p>
                <p class="text-base">Status: {{ character.status }} {{character.id}}</p>
                <p class="text-base">Last known location: {{ character.location.name }}</p>
                <button @click="showCharacterEpisodes(character)" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Voir les épisodes</button>
            </li>
        </ul>
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

        };
    },
    methods: {

        loadCharacters() {
            axios.get('https://rickandmortyapi.com/api/character')
                .then(response => {
                    this.characterList = response.data.results;
                    console.log("test characters", this.characterList);
                })
                .catch(error => {
                    console.log('Error in loading:', error);
                });
        },

        showCharacterEpisodes(character) {
            // Выполните запрос к API, чтобы получить серии для выбранного персонажа
            axios.get(`/api/character-episodes/${character.id}`)
                .then((response) => {
                    this.characterEpisodes = response.data;
                    this.selectedCharacter = character;
                    this.showEpisodesPopup = true;
                })
                .catch((error) => {
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



