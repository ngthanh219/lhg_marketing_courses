import actionParams from "./index";

let video = {
    getVideos({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.accessToken}
        return new Promise((resolve, reject) => {
            axios.get(actionParams.API + 'videos' + form.query)
            .then((res) => {
                actionParams.resetFormError(form.error);
                resolve(res.data);
            })
            .catch((err) => {
                reject(actionParams.getError(err, form.error));
            })
        });
    },

    updateVideo({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.accessToken}
        return new Promise((resolve, reject) => {
            axios.post(actionParams.API + 'videos/' + form.id, form.request)
            .then((res) => {
                actionParams.resetFormError(form.error);
                resolve(res.data);
            })
            .catch((err) => {
                reject(actionParams.getError(err, form.error));
            })
        });
    },

    deleteVideo({state}, form) {
        axios.defaults.headers.common = {'Authorization': `Bearer ` + state.auth.accessToken}
        return new Promise((resolve, reject) => {
            axios.delete(actionParams.API + 'videos/' + form.id)
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

export default video;
