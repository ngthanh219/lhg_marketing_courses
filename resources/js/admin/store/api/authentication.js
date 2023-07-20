import actionParams from "./index";

let authentication = {
    login({state}, form) {
        return new Promise((resolve, reject) => {
            axios.post(actionParams.API + 'login', form.request)
            .then((res) => {
                if (form.error) {
                    for (var param in form.error) {
                        form.error[param] = '';
                    }
                }

                resolve(res.data);
            })
            .catch((err) => {
                reject(actionParams.getError(err, form.error));
            })
        });
    },
}

export default authentication;
