import actionParams from "./index";

let user = {
    getUsers({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.accessToken}
        return new Promise((resolve, reject) => {
            axios.get(actionParams.API + 'users' + form.query)
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

export default user;