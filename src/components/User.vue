<template>
    <a :href="edit_url" class="user" v-if="user">
        <img :src="polaroid" :style="style">
    </a>
</template>
<script setup>
import { defineProps, computed, reactive, onMounted } from 'vue';
const data = reactive({
    angle: null
});

data.angle = randomAngle();

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
    let num;
    do {
        // Generate a number between 1 and 10
        num = Math.floor(Math.random() * 15) - 7;

    } while (num >= -5 && num <= 5); // Keep recalculating if the number is between -5 and 5
    console.log(num);
    return num;
}
</script>
<style scoped>
.user {}

.user img {
    /* transition: all .5s ease-in-out; */
    display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
}
</style>