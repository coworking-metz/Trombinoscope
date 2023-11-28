<template>
    <div class="user bgloader" :class="{ 'laureat-avent': afficherLaureat }" v-if="user" :style="style">
        <template v-if="data.ready">

            <template v-if="data.userData">
                <etoiles v-if="reglages.rankingMode == 'etoiles'" :ranking="data.userData.ranking" />
                <medaille v-if="reglages.rankingMode == 'medaille'" :ranking="data.userData.ranking"
                    :userData="data.userData" />
            </template>

            <template v-if="laureatAvent">
                <div class="mention">Gagnant du jour!</div>
                <img class="picto" :src="reglages?.avent.picto_avent">
            </template>
        </template>
        <template v-if="anniversaire > 0">
            <img class="picto" :src="reglages.data?.divers?.picto_anniversaire">
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

import { computed, reactive, onMounted, ref, watch } from 'vue';
import { sAvent } from "@/stores/avent";
import { sReglages } from "@/stores/reglages";
import { calculateAge } from '@/mixins/utils';

const img = ref(null);

const avent = sAvent();
const reglages = sReglages();

const data = reactive({
    afficherLaureat: false,
    ready: false,
    angle: null,
    vitesse: null,
    userData: null
});

onMounted(() => {
    img.value.addEventListener('load', () => {
        data.ready = true
    })
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
const laureatAvent = computed(() => avent.tirage == props.user.wpUserId)
const afficherLaureat = computed(() => data.ready && data.afficherLaureat && laureatAvent.value)

watch(laureatAvent, (newVal, oldVal) => {
    console.log('laureatAvent', newVal)
    if (newVal) {
        data.afficherLaureat = true;
        document.body.classList.add('grise')
        setTimeout(() => {
            document.body.classList.remove('grise')
            data.afficherLaureat = false;
        }, 5000);
    }
});

const wanted = computed(() => {
    if (props.user.balance < 0) return true;
    if (!props.user.membershipOk) return true;
});


const anniversaire = computed(() => {
    return calculateAge(props.user.birthDate)
})
const style = computed(() => {
    if (data.afficherLaureat) return;

    return {
        'transition': `all ${data.vitesse}ms ease`,
        'transform': `rotate(${data.angle}deg)`
    }

});
const edit_url = computed(() => {
    return 'https://www.coworking-metz.fr/wp-admin/user-edit.php?user_id=' + props.user.wpUserId + '&wp_http_referer=%2Fwp-admin%2Fusers.php';
});
const polaroid = computed(() => {
    return polaroid_url();
})
const polaroidHd = computed(() => {
    return polaroid_url(true);
})
const pdf_url = computed(() => {
    return 'https://coworking-metz.fr/polaroid/pdf.php?id=' + props.user.wpUserId + '';
})
function polaroid_url(hd = false) {
    let name = props.user.wpUserId;
    if (anniversaire.value) {
        name += '-anniversaire';
    }
    if (hd) {
        name += '-hd';
    }
    return 'https://coworking-metz.fr/polaroid/' + name + '.jpg?2';

}
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
<style>
.user {
    display: block;
    aspect-ratio: 400/480;
    position: relative;
    transition: all 0.5s ease;
}

.user:not(:hover) .actions {
    display: none;
}

.user .picto {
    position: absolute;
    top: 0;
    right: 0;
    width: 25%;
    transform: rotate(35deg) translate(0, -50%);
}

.user .actions {
    width: 100%;
    height: 100%;
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
}

.user .mention {
    position: absolute;
    top: -.5vw;
    left: 50%;
    transform: translateX(-50%);
    font-family: 'eveleth';
    background-color: var(--orange);
    padding: .5vw;
    white-space: nowrap;
    border-radius: .5vw;
    font-size: .5vw;
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

.user.wanted {
    outline: .25vw dashed red;
}

.user.laureat-avent {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(2);
    z-index: 999;
}
</style>