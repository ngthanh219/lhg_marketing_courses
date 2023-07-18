import { createRouter, createWebHistory } from 'vue-router';

import routes from "./routes";

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'active',
    scrollBehavior: (to) => {
        if (to.hash) {
            return {selector: to.hash}
        } else {
            return {x: 0, y: 0}
        }
    }
});
  
export default router;
