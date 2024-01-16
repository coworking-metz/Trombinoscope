<script setup>
import NavBar from '@/components/NavBar.vue';
import Trombinoscope from '@/components/Trombinoscope.vue';
import { sReglages } from "@/stores/reglages";
import { onMounted, computed } from 'vue';
import { sUsers } from "@/stores/users";
import Chocolat from '@/components/medailles/Chocolat.vue';
import Gold from '@/components/medailles/Gold.vue';
import Bronze from '@/components/medailles/Bronze.vue';
import Silver from '@/components/medailles/Silver.vue';


const reglages = sReglages();
const users = sUsers();

const ready = computed(() => {
  if (!reglages.data) return;
  if (!users.data) return;
  return true;
})
onMounted(() => {
  reglages.load(() => {
    reglages.setRankingMode();
    reglages.loadRanking();
    users.load();
  });
})
</script>

<template>
  <template v-if="ready">
    <!-- <NavBar />-->
    <Trombinoscope />
    <footer>
      <div class="mentions"><span class="mention-wanted"><b style="color:red">En rouge:</b> Solde négatif ou adhésion
          manquante</span></div>
      <!-- Choisissez votre polaroïd sur le site du coworking, dans le menu "Mon compte". -->
      <div class="etoiles" v-if="reglages.rankingMode == 'etoiles'">
      </div>
      <div class="medailles" v-if="reglages.rankingMode == 'medaille'">
        <div>Adhérent(e) depuis</div>
        <div>
          <chocolat></chocolat>
          <span>moins d'1 an</span>
        </div>
        <div>
          <bronze></bronze>
          <span>1 an</span>
        </div>
        <div>
          <silver></silver>
          <span>2 ans</span>
        </div>
        <div>
          <gold></gold>
          <span>4 ans ou plus</span>
        </div>

      </div>
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
  position: fixed;
  min-height: 10vh;
  bottom: 0;
  width: 100vw;
}

footer .mentions {
  position: absolute;
  bottom: 2vh;
  left: 2vh;
}

footer .medailles {
  position: absolute;
  bottom: 2vh;
  right: 2vh;
  display: flex;
  gap: 1vh;
}



footer .medailles>div {
  position: relative;
  display: flex;
  align-items: center;
  font-family: sans-serif;
  font-weight: bold;
  font-size: 1.4vh;
  gap: .5vh;
}

footer .medailles>div svg {
  height: 2.5vh;
  width: 2.5vh;
  position: relative;
  z-index: 0;
}
</style>
