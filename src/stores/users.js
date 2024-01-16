import { defineStore } from "pinia";
import { useApi } from "@/mixins/api.js";
import { array_shuffle } from "@/mixins/utils.js";
import { sReglages } from "@/stores/reglages";


const api = useApi();

export const sUsers = defineStore("users", {
    state: () => ({
        data: false,
    }),
    getters: {
        taille(state) {
            if (state.data.length < 10) {
                return 'grand';
            }
            if (state.data.length < 18) {
                return 'moyen';
            }
            return 'petit';
        }
    },
    actions: {
        load() {
            const reglages = sReglages();

            const payload = {
                key: import.meta.env.VITE_APP_PORTAIL_TOKEN,
                delay: import.meta.env.VITE_APP_TICKET_DELAI || 15
            }
            api.get(`${import.meta.env.VITE_TICKETS_API_ROOT}current-users?` + Math.random(), payload).then(users => {
                reglages.data.visites.forEach(visite => {
                    users.push(visite);
                })
                this.data = array_shuffle(users);
                console.log('users', users)
            });

        },
    },
});
