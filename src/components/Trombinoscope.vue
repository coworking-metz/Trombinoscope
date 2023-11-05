<template>
    <Fond/>
    <div class="trombinoscope" :data-taille="users.taille">
        <div class="polaroids">
            <template v-for="user in users.data" :key="user.wpUserId">
                    <User :user="user"/>
            </template>
        </div>
    </div>
</template>
<script setup>
import { computed, onMounted, reactive } from 'vue';
import User from '@/components/User.vue';
import { sUsers } from "@/stores/users";
import { sAvent } from "@/stores/avent";
import Fond from '@/components/Fond.vue';

const users = sUsers();
const avent = sAvent();

onMounted(() => {

    avent.load();
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