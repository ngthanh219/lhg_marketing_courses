import authentication from './api/authentication.js';
import course from './api/course.js';
import user from './api/user.js';

let actions = {
    login: authentication.login,
    getUsers: user.getUsers,
    getCourses: course.getCourses,
}

export default actions;
