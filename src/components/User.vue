<template>
    <a :href="edit_url" class="user" v-if="user">
        <img :src="polaroid" @load="loaded" :style="style">
    </a>
</template>
<script setup>
import { defineProps, computed, reactive, onMounted } from 'vue';
const data = reactive({
    angle: null
});

function loaded() {
    data.angle = randomAngle();
    // console.log('User mounted', data.angle);
    // setTimeout(() => {
    //     data.angle = 0;
    // }, 2000 * Math.random() * 2);
};

const props = defineProps(['user']);

const style = computed(() => {
    return {
        'transform': `rotate(-${data.angle}deg)`
    }

});
const edit_url = computed(() => {
    return 'https://www.coworking-metz.fr/wp-admin/user-edit.php?user_id=' + props.user.wpUserId + '&wp_http_referer=%2Fwp-admin%2Fusers.php';
});
const polaroid = computed(() => {
    return 'https://coworking-metz.fr/polaroid/' + props.user.wpUserId + '.jpg';
})

function randomAngle() {
    return Math.floor(Math.random() * 9) - 4;
}
</script>
<style scoped>
.user {}

.user img {
    transition: all .5s ease-in-out;
    display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
}
</style>