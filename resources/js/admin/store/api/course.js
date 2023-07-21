import actionParams from "./index";

let course = {
    getCourses({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.accessToken}
        return new Promise((resolve, reject) => {
            axios.get(actionParams.API + 'courses' + form.query)
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

export default course;
