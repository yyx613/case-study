import axios from 'axios'

const role = {
    namespaced: true,
    state: {
        roles: [],
    },
    mutations: {
        setroles(state, data) {
            state.roles = data
        },
    },
    actions: {
        getAll({commit}) {
            let url = process.env.VUE_APP_API_URL + '/role/get-all'
            axios.get(url, {withCredentials: true})
            .then(res => {
                commit('setroles', res.data.roles)
            })
            .catch(err => {
                Promise.reject(err)
            })
        },
        getOne(context, id) {
            let url = process.env.VUE_APP_API_URL + '/role/get-one/' + id
            return axios.get(url, {withCredentials: true})
            .then(res => {
                return Promise.resolve(res)
            })
            .catch(err => {
                return Promise.reject(err)
            })
        },
        getAssignedEmployees(context, id) {
            let url = process.env.VUE_APP_API_URL + '/role/assigned-employees/' + id
            return axios.get(url, {withCredentials: true})
            .then(res => {
                return Promise.resolve(res)
            })
            .catch(err => {
                return Promise.reject(err)
            })
        },
        create(context, form) {
            let url = process.env.VUE_APP_API_URL + '/role/create'
            console.log(url)
            return axios.post(url, form, {withCredentials: true})
            .then(res => {
                return Promise.resolve(res)
            })
            .catch(err => {
                return Promise.reject(err)
            })
        },
        edit(context, {form, id}) {
            let url = process.env.VUE_APP_API_URL + '/role/edit/' + id
            return axios.post(url, form, {withCredentials: true})
            .then(res => {
                return Promise.resolve(res)
            })
            .catch(err => {
                return Promise.reject(err)
            })
        },
        delete(context, id) {
            let url = process.env.VUE_APP_API_URL + '/role/delete/' + id
            return axios.get(url, {withCredentials: true})
            .then(res => {
                return Promise.resolve(res)
            })
            .catch(err => {
                return Promise.reject(err)
            })
        },
    },
}

export default role
