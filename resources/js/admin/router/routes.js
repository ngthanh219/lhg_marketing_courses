import Layout from "../components/Layout.vue";
import NotFoundV1 from "../components/pages/not-found/NotFoundV1.vue";

import Login from "../components/pages/auth/Login.vue";
import User from "../components/pages/users/User.vue";
import Course from "../components/pages/courses/Course.vue";
import CourseSection from "../components/pages/course-sections/CourseSection.vue";
import Video from "../components/pages/videos/Video.vue";
import VideoObject from "../components/pages/videos/VideoObject.vue";
import CourseUser from "../components/pages/course-users/CourseUser.vue";
import Post from "../components/pages/posts/Post.vue";
import Book from "../components/pages/books/Book.vue";
import BookUser from "../components/pages/book-users/BookUser.vue";

const routes = [
    {
        path: '/admin/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/admin',
        name: 'Layout',
        component: Layout,
        children: [
            {
                path: 'users',
                name: 'User',
                component: User
            },
            {
                path: 'courses',
                name: 'Course',
                component: Course,
            },
            {
                path: 'course-sections',
                name: 'CourseSection',
                component: CourseSection
            },
            {
                path: 'videos',
                name: 'Video',
                component: Video
            },
            {
                path: 'video-object',
                name: 'VideoObject',
                component: VideoObject
            },
            {
                path: 'course-users',
                name: 'CourseUser',
                component: CourseUser
            },
            {
                path: 'posts',
                name: 'Post',
                component: Post
            },
            {
                path: 'books',
                name: 'Book',
                component: Book
            },
            {
                path: 'book-users',
                name: 'BookUser',
                component: BookUser
            },
            {
                path: ':pathMatch(.*)*',
                name: 'NotFoundV1',
                component: NotFoundV1
            }
        ]
    }
]

export default routes;

