import actionParams from "./index";

let authentication = {
    login({state}, form) {
        return new Promise((resolve, reject) => {
            axios.post(actionParams.API + 'login', form.request)
            .then((res) => {
                actionParams.resetFormError(form.error);
                resolve(res.data);
            })
            .catch((err) => {
                reject(actionParams.getError(err, form.error));
            })
        });
    },

    sendVerifyCode({state}, form) {
        return new Promise((resolve, reject) => {
            axios.post(actionParams.API + 'send-verify-code', form.request)
            .then((res) => {
                actionParams.resetFormError(form.error);
                resolve(res.data);
            })
            .catch((err) => {
                reject(actionParams.getError(err, form.error));
            })
        });
    },

    register({state}, form) {
        return new Promise((resolve, reject) => {
            axios.post(actionParams.API + 'register', form.request)
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

export default authentication;
