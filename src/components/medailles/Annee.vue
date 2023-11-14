<template>
    <text x="33.768" y="131.39" font-family="&quot;Arial-BoldMT&quot;,&quot;Arial&quot;,sans-serif" font-size="60"
        font-weight="700" v-html="annee"></text>
</template>

<script setup>
import { computed } from 'vue';
const props = defineProps(['annee']);
const annee = computed(() => {
    if (!props.annee) return
    return (props.annee+'').replaceAll(' ', '&nbsp;');
})
</script>   