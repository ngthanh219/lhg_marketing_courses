import authentication from './api/authentication.js';
import course from './api/course.js';
import post from './api/post.js';
import book from './api/book.js';

let actions = {
    login: authentication.login,
    sendVerifyCode: authentication.sendVerifyCode,
    register: authentication.register,
    getInfo: authentication.getInfo,

    getCourses: course.getCourses,
    getCourseDetail: course.getCourseDetail,
    registerCourse: course.registerCourse,
    getDV: course.getDV,

    getPosts: post.getPosts,
    getPostDetail: post.getPostDetail,

    getBooks: book.getBooks,
    getBookDetail: book.getBookDetail,
}

export default actions;
