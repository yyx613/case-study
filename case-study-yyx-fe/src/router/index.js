import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import(/* webpackChunkName: "login" */ '../views/auth/Login.vue')
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import(/* webpackChunkName: "register" */ '../views/auth/Register.vue')
  },
  {
    path: '/add-employee',
    name: 'AddEmployee',
    component: () => import(/* webpackChunkName: "add-employee" */ '../views/employee/AddEmployee.vue'),
    meta: {
      'isAuthenticated': true
    }
  },
  {
    path: '/edit-employee/:id',
    name: 'EditEmployee',
    component: () => import(/* webpackChunkName: "edit-employee" */ '../views/employee/EditEmployee.vue'),
    meta: {
      'isAuthenticated': true
    }
  },
  {
    path: '/add-address',
    name: 'AddAddress',
    component: () => import(/* webpackChunkName: "add-address" */ '../views/address/AddAddress.vue'),
    meta: {
      'isAuthenticated': true
    }
  },
  {
    path: '/edit-address/:id',
    name: 'EditAddress',
    component: () => import(/* webpackChunkName: "edit-address" */ '../views/address/EditAddress.vue'),
    meta: {
      'isAuthenticated': true
    }
  },
  {
    path: '/add-roles',
    name: 'AddRole',
    component: () => import(/* webpackChunkName: "add-roles" */ '../views/role/AddRole.vue'),
    meta: {
      'isAuthenticated': true
    }
  },
  {
    path: '/edit-role/:id',
    name: 'EditRole',
    component: () => import(/* webpackChunkName: "edit-roles" */ '../views/role/EditRole.vue'),
    meta: {
      'isAuthenticated': true
    }
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  if('isAuthenticated' in to.meta && to.meta.isAuthenticated) {
    if(localStorage.getItem('autoLogin') != null) {
      next()
    } else {
      next('login')
    }
  } else {
    next()
  }
})
export default router
