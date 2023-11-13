<template>
    <div class="etoiles" :title="props.ranking">

        <template v-for="etoile in etoiles">
            <starEmpty v-if="etoile == 'empty'"/>
            <starFull v-if="etoile == 'full'"/>
            <starHalf v-if="etoile == 'half'"/>
        </template>
    </div>
</template>
<script setup>
import starEmpty from '@/components/etoiles/StarEmpty.vue';
import starHalf from '@/components/etoiles/StarHalf.vue';
import starFull from '@/components/etoiles/StarFull.vue';
import { sReglages } from "@/stores/reglages";
import { computed, onMounted } from 'vue';
const props = defineProps(['ranking']);
const reglages = sReglages();

const ranking = computed(() => {
    const totalPeople = reglages.users.length;
    const rank = props.ranking;
    if (totalPeople < 1 || rank < 1 || rank > totalPeople) return null; // invalid input
    return 5 - (5 * (rank - 1) / (totalPeople - 1));
});

const etoiles = computed(() => {
    const ret = [];
    for (let i = 0; i < 5; i++) {
        if (ranking.value >= i+1) {
            ret.push('full');
        } else if (Math.ceil(ranking.value) == i+1) {
            ret.push('half');
        } else {
            ret.push('empty');

        }
    }
    return ret;
})
onMounted(() => {

    // console.log(etoiles.value, ranking.value)
})

</script>
<style>
.etoiles {
    position: absolute;
    display: flex;
    justify-content:flex-end;
    bottom: 22%;
    right:8%;
}

.etoiles svg {
    width: 10%;
    aspect-ratio: 1;
    fill: #c9a548;
    color:white;
}
</style>