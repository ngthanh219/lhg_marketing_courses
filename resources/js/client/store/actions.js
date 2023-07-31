import authentication from './api/authentication.js';
import course from './api/course.js';
import post from './api/post.js';

let actions = {
    login: authentication.login,
    sendVerifyCode: authentication.sendVerifyCode,
    register: authentication.register,

    getCourses: course.getCourses,
    getCourseDetail: course.getCourseDetail,
    registerCourse: course.registerCourse,
    getDV: course.getDV,

    getPosts: post.getPosts,
    getPostDetail: post.getPostDetail,
}

export default actions;
