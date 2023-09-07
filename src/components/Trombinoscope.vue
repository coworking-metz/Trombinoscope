<template>
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
    users: []
});
const taille = computed(() => {
    return data.users.length > 8 ? 'beaucoup' : 'pas-beaucoup';
});
onMounted(() => {
    console.log('Trombinoscope mounted');
    fetch(`https://tickets.coworking-metz.fr/api/current-users?key=${import.meta.env.VITE_APP_PORTAIL_TOKEN}&delay=15`)
        .then(response => response.json())
        .then(users => data.users = users.slice(0, 90));
});
</script>
<style>
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
    max-width: 20vw;
    aspect-ratio: 1;
}

[data-taille="beaucoup"] .user {
    max-width: 15vw;
}

.polaroids::after {
    /* content: ""; */
    flex: auto;
}
</style>