import {createRouter, createWebHistory} from 'vue-router'
import Home                             from "../views/pages/Home";
import BlogCreate                       from "../views/pages/blog/Create";
import BlogList                         from "../views/pages/blog/List";
import BlogShow                         from "../views/pages/blog/Show";

const routes = [
    {
        path     : '/',
        name     : 'Home',
        component: Home
    },
    {
        path     : '/blog',
        name     : 'BlogList',
        component: BlogList
    },
    {
        path     : '/blog/create',
        name     : 'BlogCreate',
        component: BlogCreate
    },
    {
        path     : '/blog/:id/show',
        name     : 'BlogShow',
        component: BlogShow
    },
    {
        path     : '/blog/:id/edit',
        name     : 'BlogEdit',
        component: BlogCreate
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})
export default router
