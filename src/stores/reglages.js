import { defineStore } from "pinia";
import { useApi } from "@/mixins/api.js";

const api = useApi();

export const sReglages = defineStore("reglages", {
    persist: true,
    state: () => ({
        data: false,
    }),
    getters: {
        fond(state) {
            return state.data?.fond;
        },
        avent(state) {
            return state.data?.avent;
        }
    },
    actions: {
        load() {

            api.get('trombi')
                .then(response => {
                    this.data = Object.assign({}, response);
                })

        },
    },
});
