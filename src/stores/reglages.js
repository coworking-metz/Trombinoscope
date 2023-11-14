import { defineStore } from "pinia";
import { useApi } from "@/mixins/api.js";

const api = useApi();

export const sReglages = defineStore("reglages", {
    persist: true,
    state: () => ({
        data: false,
        users: false,
        rankingMode: false
    }),
    getters: {
        getUser: (state) => (wpUserId) => {
            return state.users.find(user => {
                if (!user.wpUserId) return;
                return user.wpUserId == wpUserId
            });
        },
        fond(state) {
            return state.data?.fond;
        },
        avent(state) {
            return state.data?.avent;
        }
    },
    actions: {
        setRankingMode() {
            this.rankingMode = 'medaille';
            return;
            if (Math.round(Math.random(0, 1))) {
                this.rankingMode = 'etoiles'
            } else {
                this.rankingMode = 'medaille';
            }
        },
        loadRanking() {
            return new Promise((resolve, reject) => {
                const cacheKey = 'rankingData';
                const timestamp = localStorage.getItem(cacheKey);
                const now = new Date();

                if (timestamp) {
                    const lastFetch = new Date(timestamp);
                    const oneDay = 24 * 60 * 60 * 1000; // Milliseconds in a day

                    if (now - lastFetch < oneDay) {
                        resolve(this.users);
                        return;
                    }
                }

                api.get('https://tickets.coworking-metz.fr/api/users-stats?key=bupNanriCit1&period=last-365-days&sort=createdAt')
                    .then(users => {
                        localStorage.setItem(cacheKey, now);
                        this.users = [...users].sort((a, b) => new Date(a.createdAt) - new Date(b.createdAt));
                        resolve(this.users);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        load() {

            api.get('trombi')
                .then(response => {
                    this.data = Object.assign({}, response);
                })

        },
    },
});
