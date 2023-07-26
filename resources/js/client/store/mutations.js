export default {
    setIsUpdating(state, isUpdating) {
        state.isUpdating = isUpdating;
    },

    setAuth(state, auth) {
        state.auth = auth;
    },

    setNotification(state, notification) {
        state.notification = notification;
    },

    setIsPageLoading(state, isPageLoading) {
        state.isPageLoading = isPageLoading;
    }
}
