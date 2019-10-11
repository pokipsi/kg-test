import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        loggedIn: false
    },
    getters: {
        loggedIn(state) {
            return state.loggedIn;
        }
    },
    mutations: {
        updateLoggedIn(state, payload) {
            state.loggedIn = payload.loggedIn;
        }
    },
    actions: {}
});

export default store;