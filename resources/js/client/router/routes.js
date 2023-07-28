import Layout from "../components/Layout.vue";

import NotFoundV1 from "../components/pages/not-found/NotFoundV1.vue";
import Login from "../components/pages/auth/Login.vue";
import Register from "../components/pages/auth/Register.vue";
import Home from "../components/pages/Home.vue";
import CourseList from "../components/pages/courses/CourseList.vue";
import CourseDetail from "../components/pages/courses/CourseDetail.vue";
import RegisterCourse from "../components/pages/register-course/RegisterCourse.vue";

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
                path: '/courses',
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
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        component: NotFoundV1
    },
]

export default routes;

