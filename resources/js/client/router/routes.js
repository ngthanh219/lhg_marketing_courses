import Layout from "../components/Layout.vue";

import NotFoundV1 from "../components/pages/not-found/NotFoundV1.vue";
import Login from "../components/pages/auth/Login.vue";
import Register from "../components/pages/auth/Register.vue";
import Home from "../components/pages/Home.vue";
import Course from "../components/pages/courses/Course.vue";

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
                path: '/khoa-hoc/:courseSlug',
                name: 'Course',
                component: Course
            },
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        component: NotFoundV1
    },
]

export default routes;

