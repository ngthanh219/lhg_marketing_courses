import Layout from "../components/Layout.vue";
import NotFoundV1 from "../components/pages/not-found/NotFoundV1.vue";

import Login from "../components/pages/auth/Login.vue";
import User from "../components/pages/users/User.vue";
import Course from "../components/pages/courses/Course.vue";
import Video from "../components/pages/videos/Video.vue";
import Billing from "../components/pages/billing/Billing.vue";

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
                component: Course
            },
            {
                path: 'videos',
                name: 'Video',
                component: Video
            },
            {
                path: 'billing',
                name: 'Billing',
                component: Billing
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

