<template>
    <section>
        <h1>Personnages</h1>
        <ul>
            <li v-for="character in characters" :key="character.id" @click="selectCharacter(character)">
                <img :src="character.image" :alt="character.name">
                <p>{{ character.name }} {{ character.gender ? character.gender : 'Unknown' }}</p>
            </li>

        </ul>
        <div v-if="selectedCharacter">
            <h2>Episodes for {{ selectedCharacter.name }}</h2>
            <ul>
                <li v-for="episode in episodes" :key="episode.id">
                    {{ episode.name }} - {{ episode.episodes }}
                </li>
            </ul>
        </div>
        <h1 class="text-2xl font-bold">Personnages</h1>
    </section>
</template>
<script>

import axios from "axios";
export default {
    name: 'Characters',
    data() {
        return {
            characters: [],
            selectedCharacter: null,
            episodes: []
        }
    },
    methods: {
        selectCharacter(character) {
            console.log('character.episodes:', character.episodes);
            this.selectedCharacter = character;

            if (character.episodes) {
                const episodeURLs = character.episodes.map(episodeURL => episodeURL.replace('https://rickandmortyapi.com/api/episode/', 'https://rickandmortyapi.com/api/episode/'));

                this.loadEpisodes(episodeURLs);
            }

        },

        loadEpisodes(episodeURLs) {
            axios.all(episodeURLs.map(url => axios.get(url)))
                .then(axios.spread((...responses) => {
                    this.episodes = responses.map(response => response.data);
                    console.log('episodes', this.episodes)
                }))
                .catch(error => {
                    console.log('Error loading episodes:', error);
                });
        },
        loadCharacters() {
            axios.get('https://rickandmortyapi.com/api/character')
                .then(response => {
                    this.characters = response.data.results;
                    console.log("test characters", this.characters)
                    console.log('test episodes', this.episodes)
                })
                .catch(error => {
                    console.log('Error in loading:', error);
                });
        }
    },

    created() {
        this.loadCharacters();

    }
}
</script>
