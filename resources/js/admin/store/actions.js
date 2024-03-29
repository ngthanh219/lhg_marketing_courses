import authentication from './api/authentication.js';
import course from './api/course.js';
import user from './api/user.js';
import courseSection from './api/course-section.js';
import video from './api/video.js';
import courseUser from './api/course-user.js';
import post from './api/post.js';
import book from './api/book.js';
import bookUser from './api/book-user.js';
import file from './api/file.js';

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
    getVideoObject: video.getVideoObject,
    createMultipartUpload: video.createMultipartUpload,
    signMultipartUpload: video.signMultipartUpload,
    completeMultipartUpload: video.completeMultipartUpload,
    abortMultipartUpload: video.abortMultipartUpload,
    deleteVideoObject: video.deleteVideoObject,

    getCourseUsers: courseUser.getCourseUsers,
    createCourseUser: courseUser.createCourseUser,
    updateCourseUser: courseUser.updateCourseUser,
    deleteCourseUser: courseUser.deleteCourseUser,

    getPosts: post.getPosts,
    createPost: post.createPost,
    updatePost: post.updatePost,
    deletePost: post.deletePost,

    getBooks: book.getBooks,
    createBook: book.createBook,
    updateBook: book.updateBook,
    deleteBook: book.deleteBook,

    getBookUsers: bookUser.getBookUsers,
    updateBookUser: bookUser.updateBookUser,
    deleteBookUser: bookUser.deleteBookUser,

    uploadFile: file.upload,
    removeFile: file.remove,
}

export default actions;
