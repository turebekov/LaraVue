import Vue from 'vue'

import VueRouter from 'vue-router'

import Register from '../views/auth/Register.vue'
import Login from '../views/auth/Login.vue'
import BookIndex from '../views/Books/Index.vue'
import BookShow from '../views/Books/Show.vue'
import BookForm from '../views/Books/Form.vue'


Vue.use(VueRouter)


const router = new VueRouter({
    routes:[

        {
            path:'/',
            component:BookIndex
        },
        {
            path:'/books/create',
            component:BookForm,
            meta: {mode: 'create'}
        },
        {
            path:'/books/:id/edit',
            component:BookForm,
            meta: {mode: 'edit'}
        },
        {
            path:'/books/:id',
            component: BookShow
        },
        {
            path:'/register',
            component:Register
        },
        {
            path:'/login',
            component:Login
        }
    ]
})


export default router