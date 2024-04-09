<template>
  <div class="fond" v-if="reglages.fond && reglages.fond.image" :style="{ 'background': reglages.fond.couleur }">
    <div
      :style="{ 'background': 'url(' + reglages.fond.image + ')', 'background-size': reglages.fond.mode, 'opacity': reglages.fond.opacity }">
    </div>
  </div>
  <div class="fond" v-else>
    <img src="/src/assets/fond.webp">
  </div>
</template>
<script setup>
import { sReglages } from "@/stores/reglages";
const reglages = sReglages();
</script>