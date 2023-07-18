import actionParams from "./index";

let authentication = {
    login({state}, formRequest) {
        return new Promise((resolve, reject) => {
            axios.post(actionParams.API + 'auth/login', formRequest)
            .then((res) => {
                resolve(res.data);
            })
            .catch((err) => {
                reject(actionParams.getError(err));
            })
        });
    },
}

export default authentication;
