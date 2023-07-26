let getters = {
    isUpdating: state => {
        return state.isUpdating
    },

    auth: state => {
        return state.auth
    },

    notification: state => {
        return state.notification
    },

    isPageLoading: state => {
        return state.isPageLoading
    }
}

export default getters;
