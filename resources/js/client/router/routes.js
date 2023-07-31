import Layout from "../components/Layout.vue";

import NotFoundV1 from "../components/pages/not-found/NotFoundV1.vue";
import Login from "../components/pages/auth/Login.vue";
import Register from "../components/pages/auth/Register.vue";
import Home from "../components/pages/Home.vue";
import CourseList from "../components/pages/courses/CourseList.vue";
import CourseDetail from "../components/pages/courses/CourseDetail.vue";
import RegisterCourse from "../components/pages/register-course/RegisterCourse.vue";
import Tutorial from "../components/pages/single/Tutorial.vue";
import PostList from "../components/pages/posts/PostList.vue";
import PostDetail from "../components/pages/posts/PostDetail.vue";

const routes = [
    {
        path: '/',
        redirect: '/trang-chu'
    },
    {
        path: '/',
        component: Layout,
        children: [
            {
                path: '/dang-nhap',
                name: 'Login',
                component: Login
            },
            {
                path: '/dang-ky',
                name: 'Register',
                component: Register
            },
            {
                path: '/trang-chu',
                name: 'Home',
                component: Home,
            },
            {
                path: '/khoa-hoc',
                name: 'CourseList',
                component: CourseList
            },
            {
                path: '/:courseSlug',
                name: 'CourseDetail',
                component: CourseDetail
            },
            {
                path: '/:courseSlug/dang-ky',
                name: 'RegisterCourse',
                component: RegisterCourse
            },
            {
                path: '/huong-dan-vao-hoc',
                name: 'Tutorial',
                component: Tutorial
            },
            {
                path: '/bai-viet',
                name: 'PostList',
                component: PostList
            },
            {
                path: '/bai-viet/:postSlug',
                name: 'PostDetail',
                component: PostDetail
            },
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        component: NotFoundV1
    },
]

export default routes;

