import { defineStore } from "pinia";
import { useApi } from "@/mixins/api.js";
import { dateDuJour, estDansPlageDeDates, isCurrentTimeAfter } from '@/mixins/utils';
import { sReglages } from "@/stores/reglages";
import { sUsers } from "@/stores/users";
import { toRaw } from 'vue'
const api = useApi();

/**
 * Initialise le magasin avec l'état de base.
 * @returns {Object} L'état initial du magasin.
 */
export const sAvent = defineStore("avent", {
    state: () => ({
        tirage: false,
        tirages: false,
    }),
    getters: {
    },
    actions: {
        /**
         * Charge les données nécessaires pour l'opération de l'avent si dans la période appropriée.
         */
        load() {
            const reglages = sReglages();
            if (!reglages?.avent) return;
            if (!estDansPlageDeDates(reglages?.avent.debut_avent, reglages?.avent.fin_avent)) return;
            console.log('Avent !')
            this.getTirages().then(() => {
                this.getTirageJour().then(() => {
                    if (this.tirage) {
                        console.log('Avent - Le tirage a déjà été fait ce jour !')
                        return;
                    }

                    this.faireTirage();
                })
            })
        },
        /**
         * Effectue le tirage pour l'avent si l'heure actuelle est après l'heure de tirage configurée.
         */
        faireTirage() {
            const reglages = sReglages();
            const users = sUsers();
            if (isCurrentTimeAfter(reglages?.avent.heure_tirage)) {
                console.log('Avent - On fait le tirage');
                const user = users.data[Math.floor(Math.random() * users.data.length)];
                if (this.ilResteDesPersonneNonLaureatesAjourdHui()) {
                    console.log('ilResteDesPersonneNonLaureatesAjourdHui');
                    if (Object.values(this.tirages).includes(user.wpUserId)) {
                        console.log('Deja lauréat et il y a d\'autres personnes au cowo qui n\'ont pas encore gagné ! On recommence');
                        return this.faireTirage();
                    }
                }
                return api.post('trombi/avent/tirage', { date_tirage: dateDuJour(), user_id: user.wpUserId }).then(data => {
                    this.getTirageJour()
                })

            } else {
                console.log('Avent - Pas encore l\'heure du tirage')
            }

        },
        ilResteDesPersonneNonLaureatesAjourdHui() {
            const users = sUsers();
            for (const user of users.data) {
                if (!this.tirages.includes(user.wpUserId)) {
                    return true;
                }
            }
        },
        /**
         * Récupère le tirage du jour à partir de l'API.
         * @returns {Promise} Promesse qui résout avec les données de tirage.
         */
        getTirageJour() {
            return api.get('trombi/avent/tirage', { date_tirage: dateDuJour() }).then(tirage => {
                this.tirage = tirage;
            })
        },
        /**
         * Récupère les tirage précédents à partir de l'API.
         * @returns {Promise} Promesse qui résout avec les données de tirage.
         */
        getTirages() {
            return api.get('trombi/avent/tirages').then(tirages => {
                this.tirages = tirages;
            })
        }
    },
});
