import { defineStore } from "pinia";
import { useApi } from "@/mixins/api.js";

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
            const payload = {
                key: import.meta.env.VITE_APP_PORTAIL_TOKEN,
                delay: import.meta.env.VITE_APP_TICKET_DELAI || 15
            }
            api.get(`https://tickets.coworking-metz.fr/api/current-users`, payload).then(users => {
                this.data = users;
            });

        },
    },
});
