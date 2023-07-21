import authentication from './api/authentication.js';
import course from './api/course.js';
import user from './api/user.js';
import courseSection from './api/course-section.js';

let actions = {
    login: authentication.login,
    getUsers: user.getUsers,
    getCourses: course.getCourses,
    getCourseSections: courseSection.getCourseSections
}

export default actions;
