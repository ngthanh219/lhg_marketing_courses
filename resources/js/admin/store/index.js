import { createStore } from 'vuex';
import createPersistedState from "vuex-persistedstate";

import actions from './actions';
import mutations from './mutations';
import getters from './getters';

const store = createStore({
    state: {
        isUpdating: false,
        isPageLoading: false,
        auth: {
            user: null,
            accessToken: null
        },
        notification: {
            success: 0,
            message: null
        },
    },
    actions,
    mutations,
    getters,
    plugins: [
        createPersistedState({
            key: 'c_user'
        })
    ],
});

export default store;
