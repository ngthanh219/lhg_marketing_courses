import authentication from './api/authentication.js';

let actions = {
    login: authentication.login,
    sendVerifyCode: authentication.sendVerifyCode,
    register: authentication.register
}

export default actions;
