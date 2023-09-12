<template>
    <a :href="edit_url" class="user" v-if="user">
        <img :src="polaroid" :style="style" :data-angle="data.angle" :class="{ 'wanted': wanted }">
    </a>
</template>
<script setup>
import { defineProps, computed, reactive, onMounted, watch } from 'vue';
const data = reactive({
    angle: null,
    vitesse: null
});

onMounted(() => {

    let t = randomTime();
    data.vitesse = randomTime() / 10;
    setTimeout(() => {
        data.angle = randomAngle();
    }, t);
    if(wanted.value) {
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
    return 'https://coworking-metz.fr/polaroid/' + props.user.wpUserId + '.jpg';
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
.user img {
    box-shadow: -.3vw .3vw .5vw rgba(0, 0, 0, 0.3);
}

.user img {
    /* transition: all .5s ease-in-out; */
    display: block;
    width: 100%;
    height: 100%;
    /* object-fit: contain; */
}
.wanted {
    outline:.25vw dashed red;
}
</style>