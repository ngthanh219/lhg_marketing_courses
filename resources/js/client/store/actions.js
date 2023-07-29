import authentication from './api/authentication.js';
import course from './api/course.js';

let actions = {
    login: authentication.login,
    sendVerifyCode: authentication.sendVerifyCode,
    register: authentication.register,

    getCourses: course.getCourses,
    getCourseDetail: course.getCourseDetail,
    registerCourse: course.registerCourse,
}

export default actions;
