<template>
    <div class="user bgloader" v-if="user" :style="style">
        <template v-if="data.ready">

            <template v-if="data.userData">
                <etoiles v-if="reglages.rankingMode=='etoiles'" :ranking="data.userData.ranking"/>
                <medaille v-if="reglages.rankingMode=='medaille'" :ranking="data.userData.ranking" :userData="data.userData"/>
            </template>

            <template v-if="avent.tirage == user.wpUserId">
                <img class="picto" :src="reglages?.avent.picto_avent">
            </template>
        </template>
        <div class="actions buttons are-small">
            <div>
                <a class="button " title="Fiche" target="_blank" :href="edit_url">
                    <span class="icon is-small">
                        <i class="fas fa-user"></i>
                    </span>
                </a>
            </div>
            <div>
                <a class="button " target="_blank" title="Polaroïd format pdf" :href="pdf_url">
                    <span class="icon is-small">
                        <i class="fas fa-file-pdf"></i>
                    </span>
                </a>
            </div>
            <div>
                <a class="button " target="_blank" :href="polaroidHd" title="Polaroïd format image">
                    <span class="icon is-small">
                        <i class="fas fa-file-image"></i>
                    </span>
                </a>
            </div>
        </div>
        <img :src="polaroid" ref="img" :data-angle="data.angle" class="pola" :class="{ 'wanted': wanted }">
    </div>
</template>
<script setup>
import Etoiles from '@/components/Etoiles.vue';
import Medaille from '@/components/Medaille.vue';

import { computed, reactive, onMounted, ref } from 'vue';
import { sAvent } from "@/stores/avent";
import { sReglages } from "@/stores/reglages";

const img = ref(null);

const avent = sAvent();
const reglages = sReglages();

const data = reactive({
    ready: false,
    angle: null,
    vitesse: null,
    userData: null
});

onMounted(() => {
    img.value.addEventListener('load', () => data.ready = true)
    data.userData = reglages.getUser(props.user.wpUserId);
    data.vitesse = randomTime() / 10;
    setTimeout(() => {
        setInterval(() => {
            data.angle = randomAngle();
        }, randomTime() + 2000)
    }, randomTime());
    if (wanted.value) {
        console.log('wanted', props.user.lastName);
    }

});
const props = defineProps(['user']);

const wanted = computed(() => {
    if (props.user.balance < 0) return true;
    if (!props.user.membershipOk) return true;
});



const style = computed(() => {


    return {
        'transition': `all ${data.vitesse}ms ease`,
        'transform': `rotate(${data.angle}deg)`
    }

});
const edit_url = computed(() => {
    return 'https://www.coworking-metz.fr/wp-admin/user-edit.php?user_id=' + props.user.wpUserId + '&wp_http_referer=%2Fwp-admin%2Fusers.php';
});
const polaroid = computed(() => {
    return 'https://coworking-metz.fr/polaroid/' + props.user.wpUserId + '.jpg?2';
})
const polaroidHd = computed(() => {
    return 'https://coworking-metz.fr/polaroid/' + props.user.wpUserId + '-hd.jpg?2';
})
const pdf_url = computed(() => {
    return 'https://coworking-metz.fr/polaroid/pdf.php?id=' + props.user.wpUserId + '';
})

function randomTime() {
    return Math.floor(Math.random() * (3000 - 1000 + 1)) + 1000;
}
function randomAngle() {
    return randomSignFlip(getRandomNumber());
}
function getRandomNumber() {
    return Math.floor(Math.random() * 7) + 1.5;
}
function randomSignFlip(num) {
    return Math.random() < 0.5 ? -num : num;
}
</script>
<style scoped>
.user {
    display: block;
    aspect-ratio: 400/480;
    position: relative;
}

.user:not(:hover) .actions {
    display: none;
}

.picto {
    position: absolute;
    top: 0;
    right: 0;
    width: 40%;
    transform: rotate(35deg) translate(25%, -50%);
}

.actions {
    width: 100%;
    height: 100%;
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
}

.user img.pola {
    box-shadow: -.3vw .3vw .5vw rgba(0, 0, 0, 0.3);
}

.user img.pola {
    /* transition: all .5s ease-in-out; */
    display: block;
    width: 100%;
    height: 100%;
    /* object-fit: contain; */
}

.wanted {
    outline: .25vw dashed red;
}
</style>