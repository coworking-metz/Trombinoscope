<template>
    <div class="medaille" :title="props.ranking">
        <gold v-if="ranking == 'gold'" :annee="annee" />
        <silver v-if="ranking == 'silver'" :annee="annee" />
        <bronze v-if="ranking == 'bronze'" :annee="annee" />
        <chocolat v-if="ranking == 'chocolat'" :annee="annee" />
    </div>
</template>
<script setup>
import Chocolat from '@/components/medailles/Chocolat.vue';
import Gold from '@/components/medailles/Gold.vue';
import Bronze from '@/components/medailles/Bronze.vue';
import Silver from '@/components/medailles/Silver.vue';
import starEmpty from '@/components/etoiles/StarEmpty.vue';
import starHalf from '@/components/etoiles/StarHalf.vue';
import starFull from '@/components/etoiles/StarFull.vue';
import { sReglages } from "@/stores/reglages";
import { computed, onMounted } from 'vue';
const props = defineProps(['ranking', 'userData']);
const reglages = sReglages();

const ranking = computed(() => {
    const annee_courante = new Date().getFullYear();
    const depuis = annee_courante - annee.value;
    if (annee_courante == annee.value)
        return 'chocolat';
    if (depuis > 4)
        return 'gold';
    else if (depuis > 2)
        return 'silver';
    else
        return 'bronze';
});

const annee = computed(() => {
    if (!props.userData) return;
    if (props.userData.createdAt.includes('2015-09-22')) return 2014;
    return props.userData.createdAt.split('-')[0]
})
onMounted(() => {
    console.log(ranking.value)

})

</script>
<style>
.medaille {
    position: absolute;
    bottom: 12%;
    right: 3%;
    z-index: 2;
    width: 18%;
    transform: rotate(32deg);
}

.medaille svg {}
</style>