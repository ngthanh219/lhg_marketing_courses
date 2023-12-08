import actionParams from "./index";

let book = {
    getBooks({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.accessToken}
        return new Promise((resolve, reject) => {
            axios.get(actionParams.API + 'books' + form.query)
            .then((res) => {
                actionParams.resetFormError(form.error);
                resolve(res.data);
            })
            .catch((err) => {
                reject(actionParams.getError(err, form.error));
            })
        });
    },

    createBook({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.accessToken}
        return new Promise((resolve, reject) => {
            axios.post(actionParams.API + 'books', form.request)
            .then((res) => {
                actionParams.resetFormError(form.error);
                resolve(res.data);
            })
            .catch((err) => {
                reject(actionParams.getError(err, form.error));
            })
        });
    },

    updateBook({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.accessToken}
        return new Promise((resolve, reject) => {
            axios.post(actionParams.API + 'books/' + form.id, form.request)
            .then((res) => {
                actionParams.resetFormError(form.error);
                resolve(res.data);
            })
            .catch((err) => {
                reject(actionParams.getError(err, form.error));
            })
        });
    },

    deleteBook({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.accessToken}
        return new Promise((resolve, reject) => {
            axios.delete(actionParams.API + 'books/' + form.id)
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

export default book;
