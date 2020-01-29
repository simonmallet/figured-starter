import VueRouter from 'vue-router'

import Home from './pages/Home'
import AdminDashboard from './pages/AdminDashboard'
import AddArticle from './pages/AddArticle'
import Login from './pages/Login'

// Routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            auth: undefined
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    {
        path: '/admin',
        name: 'admin.dashboard',
        component: AdminDashboard,
        meta: {
            auth: true
        }
    },
    {
        path: '/admin/article',
        name: 'admin.add.article',
        component: AddArticle,
        meta: {
            auth: true
        }
    },
];

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
});

export default router
