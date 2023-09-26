<template>
    <div class="user" v-if="user" :style="style">
        <div class="actions buttons are-small">
            <div>
                <a class="button " target="_blank" :href="edit_url">
                    <span class="icon is-small">
                        <i class="fas fa-user"></i>
                    </span>
                </a>
            </div>
            <div>
                <a class="button " target="_blank" :href="pdf_url">
                    <span class="icon is-small">
                        <i class="fas fa-file-pdf"></i>
                    </span>
                </a>
            </div>
            <div>
                <a class="button " target="_blank" :href="polaroidHd">
                    <span class="icon is-small">
                        <i class="fas fa-file-image"></i>
                    </span>
                </a>
            </div>
        </div>
        <img :src="polaroid" :data-angle="data.angle" :class="{ 'wanted': wanted }">
    </div>
</template>
<script setup>
import { defineProps, computed, reactive, onMounted, watch } from 'vue';
const data = reactive({
    angle: null,
    vitesse: null
});

onMounted(() => {

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
    return 'https://coworking-metz.fr/polaroid/' + props.user.wpUserId + '.jpg';
})
const polaroidHd = computed(() => {
    return 'https://coworking-metz.fr/polaroid/' + props.user.wpUserId + '-hd.jpg';
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
    background: white no-repeat center;
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" xml:space="preserve"><path fill="%23ccc" d="M73 50c0-12.7-10.3-23-23-23S27 37.3 27 50m3.9 0c0-10.5 8.5-19.1 19.1-19.1S69.1 39.5 69.1 50"><animateTransform attributeName="transform" attributeType="XML" type="rotate" dur=".5s" from="0 50 50" to="360 50 50" repeatCount="indefinite"/></path></svg>');
    background-size: 50% auto;
    position: relative;
}

.user:not(:hover) .actions {
    display: none;
}

.actions {
    width: 100%;
    height: 100%;
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
}

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
    outline: .25vw dashed red;
}
</style>