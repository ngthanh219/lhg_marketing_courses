let getters = {
    isLoadingLogin: state => {
        return state.isLoadingLogin
    },
    auth: state => {
        return state.auth
    },
    notification: state => {
        return state.notification
    }
}

export default getters;
