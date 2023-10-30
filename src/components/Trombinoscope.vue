<template>
    <div class="fond" v-if="data.reglages?.fond?.image" :style="{ 'background': data.reglages.fond.couleur }">
        <div :style="{ 'background': 'url(' + data.reglages.fond.image + ')', 'background-size': data.reglages.fond.mode, 'opacity': data.reglages.fond.opacity }">
        </div>
    </div>
    <div class="fond" v-else>
        <img src="/src/assets/fond.webp">
    </div>
    <div class="trombinoscope" :data-taille="taille">
        <div class="polaroids">
            <User v-for="user in data.users" :key="user.wpUserId" :user="user" />
        </div>
    </div>
</template>
<script setup>
import { computed, onMounted, reactive } from 'vue';
import User from './User.vue';

const data = reactive({
    users: [],
    reglages: {}
});
const taille = computed(() => {
    if (data.users.length < 10) {
        return 'grand';
    }
    if (data.users.length < 18) {
        return 'moyen';
    }
    return 'petit';
});
onMounted(() => {
    fetch('https://www.coworking-metz.fr/api-json-wp/cowo/v1/polaroids')
        .then(response => response.json())
        .then(response => {
            data.reglages = response;
        })
    fetch(`https://tickets.coworking-metz.fr/api/current-users?key=${import.meta.env.VITE_APP_PORTAIL_TOKEN}&delay=15`)
        .then(response => response.json())
        .then(users => data.users = users.slice(0, 100));
});
</script>
<style>
.fond {
    position: fixed;
    z-index: -1;
    inset: 0;
}

.fond>div {
    position: absolute;
    inset: 0;
}

.fond>img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.trombinoscope {
    flex: 1;
    overflow: hidden;
}

.polaroids {
    display: flex;
    flex-wrap: wrap;
    gap: var(--marge);
    width: 100%;
    height: 100%;
    justify-content: center;
    align-content: center;
    /* display: grid;
    width: 100%;
    height: 100%;
    grid-template-columns: repeat(6, 1fr);
    grid-template-rows: repeat(5, 1fr);
    justify-items: center;
    align-items: center;
    grid-column-gap: var(--marge);
    grid-row-gap: var(--marge); */
}

.user {
    /* max-width: 20vw; */
    width: 17vw;

}

[data-taille="petit"] .user {
    /* max-height: 13vw; */
    width: 16vw;
    max-width: 18vh;
}

[data-taille="moyen"] .user {
    width: 23vh;
}

.polaroids::after {
    /* content: ""; */
    flex: auto;
}
</style>