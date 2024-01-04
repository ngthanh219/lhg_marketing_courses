import actionParams from "./index";

let bookUser = {
    getBookUsers({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.accessToken}
        return new Promise((resolve, reject) => {
            axios.get(actionParams.API + 'book-users' + form.query)
            .then((res) => {
                actionParams.resetFormError(form.error);
                resolve(res.data);
            })
            .catch((err) => {
                reject(actionParams.getError(err, form.error));
            })
        });
    },

    updateBookUser({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.accessToken}
        return new Promise((resolve, reject) => {
            axios.post(actionParams.API + 'book-users/' + form.id, form.request)
            .then((res) => {
                actionParams.resetFormError(form.error);
                resolve(res.data);
            })
            .catch((err) => {
                reject(actionParams.getError(err, form.error));
            })
        });
    },

    deleteBookUser({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.accessToken}
        return new Promise((resolve, reject) => {
            axios.delete(actionParams.API + 'book-users/' + form.id)
            .then((res) => {
                actionParams.resetFormError(form.error);
                resolve(res.data);
            })
            .catch((err) => {
                reject(actionParams.getError(err, form.error));
            })
        });
    },
}

export default bookUser;
