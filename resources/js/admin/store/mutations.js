export default {
    setLoadingLogin(state, isLoadingLogin) {
        state.isLoadingLogin = isLoadingLogin;
    },
    setAuth(state, auth) {
        state.auth = auth;
    },
    setNotification(state, notification) {
        state.notification = notification;
    }
}
