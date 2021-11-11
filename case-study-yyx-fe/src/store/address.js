import axios from 'axios'

const address = {
    namespaced: true,
    state: {
        addresses: []
    },
    mutations: {
        setAddresses(state, data) {
            state.addresses = data
        }
    },
    actions: {
        getAll({commit}) {
            let url = process.env.VUE_APP_API_URL + '/address/get-all'
            axios.get(url, {withCredentials: true})
            .then(res => {
                commit('setAddresses', res.data.addresses)
            })
            .catch(err => {
                Promise.reject(err)
            })
        },
        getOne(context, id) {
            let url = process.env.VUE_APP_API_URL + '/address/get-one/' + id
            return axios.get(url, {withCredentials: true})
            .then(res => {
                return Promise.resolve(res)
            })
            .catch(err => {
                return Promise.reject(err)
            })
        },
        getAssignedEmployees(context, id) {
            let url = process.env.VUE_APP_API_URL + '/address/assigned-employees/' + id
            return axios.get(url, {withCredentials: true})
            .then(res => {
                return Promise.resolve(res)
            })
            .catch(err => {
                return Promise.reject(err)
            })
        },
        create(context, form) {
            let url = process.env.VUE_APP_API_URL + '/address/create'
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
            let url = process.env.VUE_APP_API_URL + '/address/edit/' + id
            return axios.post(url, form, {withCredentials: true})
            .then(res => {
                return Promise.resolve(res)
            })
            .catch(err => {
                return Promise.reject(err)
            })
        },
        delete(context, id) {
            let url = process.env.VUE_APP_API_URL + '/address/delete/' + id
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

export default address
