<script setup>
import NavBar from '@/components/NavBar.vue';
import Trombinoscope from '@/components/Trombinoscope.vue';

</script>

<template>
  <!-- <NavBar />-->
  <Trombinoscope />
  <footer>
    <b style="color:red">En rouge: Solde négatif ou adhésion manquante</b><br>
    Choisissez votre polaroïd sur le site du coworking, dans le menu "Mon compte".
  </footer>
</template>

<style>
footer {
  padding: var(--marge);
  background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, .5) 100%);
  color:white;
}
</style>
