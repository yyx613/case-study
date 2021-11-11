import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import employee from './employee'
import address from './address'
import role from './role'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    isAuthenticated: false
  },
  mutations: {
    setIsAuthenticated(state, data) {
      state.isAuthenticated = data
    }
  },
  actions: {
    autoLogin({commit}, form){
      let url = process.env.VUE_APP_API_URL + '/user/auto-login'
      axios.post(url, form, {withCredentials: true})
      .then(res => {
        commit('setIsAuthenticated', true)
        localStorage.setItem('autoLogin', res.data.user.id)
        Promise.resolve(res)
      })
      .catch(err => {
        Promise.reject(err)
      })
    },
    login({commit}, form) {
      let url = process.env.VUE_APP_API_URL + '/user/login'
      return axios.post(url, form, {withCredentials: true})
      .then(res => {
        commit('setIsAuthenticated', true)
        localStorage.setItem('autoLogin', res.data.user.id)
        return Promise.resolve(res)
      })
      .catch(err => {
        return Promise.reject(err)
      })
    },
    logout({commit}) {
      commit('setIsAuthenticated', false)
      localStorage.removeItem('autoLogin')
    },
    register({commit}, form) {
      let url = process.env.VUE_APP_API_URL + '/user/register'
      return axios.post(url, form, {withCredentials: true})
      .then(res => {
        commit('setIsAuthenticated', true)
        localStorage.setItem('autoLogin', res.data.user.id)
        return Promise.resolve(res)
      })
      .catch(err => {
        console.log(err)
        return Promise.reject(err)
      })
    },
  },
  modules: {
    employee: employee,
    address: address,
    role: role
  }
})
