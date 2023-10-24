import "./bootstrap";
import "../sass/app.scss";

import.meta.glob([
    "../assets/img/**/*",
    "../assets/fonts/**/*"
]);

import { createApp } from "vue";

import Characters from "./components/characters.vue";

const app = createApp({});

app.component("characters", Characters);

app.mount("#app");
