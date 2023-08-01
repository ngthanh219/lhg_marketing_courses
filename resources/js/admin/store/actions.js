import authentication from './api/authentication.js';
import course from './api/course.js';
import user from './api/user.js';
import courseSection from './api/course-section.js';
import video from './api/video.js';
import courseUser from './api/course-user.js';
import post from './api/post.js';

let actions = {
    login: authentication.login,
    logout: authentication.logout,

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
    createVideo: video.createVideo,
    updateVideo: video.updateVideo,
    deleteVideo: video.deleteVideo,

    getCourseUsers: courseUser.getCourseUsers,
    createCourseUser: courseUser.createCourseUser,
    updateCourseUser: courseUser.updateCourseUser,
    deleteCourseUser: courseUser.deleteCourseUser,

    getPosts: post.getPosts,
    createPost: post.createPost,
    updatePost: post.updatePost,
    deletePost: post.deletePost,
}

export default actions;
