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

    getBookDetail({state}, form) {
        if (state.auth.accessToken) {
            axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.accessToken}
        }
        
        return new Promise((resolve, reject) => {
            axios.get(actionParams.API + 'books/' + form.slug)
            .then((res) => {
                actionParams.resetFormError(form.error);
                resolve(res.data);
            })
            .catch((err) => {
                reject(actionParams.getError(err, form.error));
            })
        });
    },

    // registerBook({state}, form) {
    //     return new Promise((resolve, reject) => {
    //         axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.accessToken}
    //         axios.post(actionParams.API + 'register-course', form.request)
    //         .then((res) => {
    //             actionParams.resetFormError(form.error);
    //             resolve(res.data);
    //         })
    //         .catch((err) => {
    //             reject(actionParams.getError(err, form.error));
    //         })
    //     });
    // },
}

export default book;
