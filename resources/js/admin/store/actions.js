import authentication from './api/authentication.js';
import course from './api/course.js';
import user from './api/user.js';
import courseSection from './api/course-section.js';
import video from './api/video.js';

let actions = {
    login: authentication.login,

    getUsers: user.getUsers,
    createUser: user.createUser,
    updateUser: user.updateUser,
    deleteUser: user.deleteUser,

    getCourses: course.getCourses,
    createCourse: course.createCourse,
    updateCourse: course.updateCourse,
    deleteCourse: course.deleteCourse,

    getCourseSections: courseSection.getCourseSections,
    createCourseSection: courseSection.createCourseSection,
    updateCourseSection: courseSection.updateCourseSection,
    deleteCourseSection: courseSection.deleteCourseSection,

    getVideos: video.getVideos,
    updateVideo: video.updateVideo,
    deleteVideo: video.deleteVideo,
}

export default actions;
