import store from '../store';
import router from '../router/index.js';

let helper = {
    setPageLoading(isPageLoading) {
        store.commit('setIsPageLoading', isPageLoading);
    },

    setAuth(data) {
        var auth = {
            user: (typeof data.user === 'undefined') ? (store.state.auth.user ? store.state.auth.user : null) : data.user,
            accessToken: (typeof data.access_token === 'undefined') ? (store.state.auth.accessToken ? store.state.auth.accessToken : null) : data.access_token,
        };

        store.commit('setAuth', auth);
    },

    setNotification(success, message) {
        store.commit('setNotification', {
            success: success,
            message: message
        });

        setTimeout(() => {
            store.commit('setNotification', {
                success: 0,
                message: null
            });
        }, 5000);
    },

    redirectPage(path, query = {}) {
        router.push({
            path: '/admin/' + path,
            query: query
        })
    },

    handleQueryParam(form) {
        var currentForm = {};

        for (var item in form) {
            if (form[item] != '' && form[item] != null) {
                currentForm[item] = form[item];
            }
        }

        return currentForm;
    },

    pushQueryUrl(params) {
        var currentForm = this.handleQueryParam(params);

        router.push({
            query: currentForm
        })
    },

    getQueryUrl() {
        return router.currentRoute.value.query
    },

    getQueryString(form) {
        var currentForm = this.handleQueryParam(form);

        return '?' + new URLSearchParams(currentForm).toString();
    },

    getCurrentQuery(query) {
        var queryUrl = this.getQueryUrl();

        for (var q in query) {
            if (typeof(queryUrl[q]) !== 'undefined') {
                query[q] = queryUrl[q];
            }
        }
    },

    appendFormData(form) {
        const formData = new FormData();

        for (var param in form) {
            formData.append(param, form[param]);
        }

        return formData;
    },

    isNumber(e) {
        let keyCode = (e.keyCode ? e.keyCode : e.which);

        if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
            e.preventDefault();
        }
    },
}

export default helper;