<script setup>
import NavBar from '@/components/NavBar.vue';
import Trombinoscope from '@/components/Trombinoscope.vue';
import { sReglages } from "@/stores/reglages";
import { onMounted, computed } from 'vue';
import { sUsers } from "@/stores/users";


const reglages = sReglages();
const users = sUsers();

const ready = computed(() => {
  if (!reglages.data) return;
  if (!users.data) return;
  return true;
})
onMounted(() => {
  reglages.load();
  users.load();
})
</script>

<template>
  <template v-if="ready">
    <!-- <NavBar />-->
    <Trombinoscope />
    <footer>
      <b style="color:red">En rouge: Solde négatif ou adhésion manquante</b><br>
      Choisissez votre polaroïd sur le site du coworking, dans le menu "Mon compte".
    </footer>
  </template>
  <template v-else>
    <div class="bgloader inset"></div>
  </template>
</template>

<style>
footer {
  padding: var(--marge);
  background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, .5) 100%);
  color: white;
}
</style>
