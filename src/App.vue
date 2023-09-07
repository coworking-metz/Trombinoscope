<script setup>
import NavBar from '@/components/NavBar.vue';
import Trombinoscope from '@/components/Trombinoscope.vue';

</script>

<template>
  <NavBar />
  <Trombinoscope />
  <footer>
    Choisissez votre polaroïd sur le site du coworking, dans le menu "Mon compte".
  </footer>
</template>

<style>
footer {
  padding: var(--marge);
}
</style>
