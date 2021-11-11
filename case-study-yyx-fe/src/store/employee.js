import axios from 'axios'

const employee = {
    namespaced: true,
    state: {
        employees: [],
        deletedEmployees: [],
    },
    mutations: {
        setEmployees(state, data) {
            state.employees = data
        },
        setDeletedEmployees(state, data) {
            state.deletedEmployees = data
        },
    },
    actions: {
        getAll({commit}, filterKeyword) {
            if(filterKeyword == undefined || filterKeyword == '') {
                filterKeyword = null
            }
            let url = process.env.VUE_APP_API_URL + '/employee/get-all/' + filterKeyword
            axios.get(url, {withCredentials: true})
            .then(res => {
                commit('setEmployees', res.data.employees)
            })
            .catch(err => {
                Promise.reject(err)
            })
        },
        getAllDeleted({commit}) {
            let url = process.env.VUE_APP_API_URL + '/employee/get-all-deleted'
            axios.get(url, {withCredentials: true})
            .then(res => {
                commit('setDeletedEmployees', res.data.employees)
            })
            .catch(err => {
                Promise.reject(err)
            })
        },
        getOne(context, id) {
            let url = process.env.VUE_APP_API_URL + '/employee/get-one/' + id
            return axios.get(url, {withCredentials: true})
            .then(res => {
                return Promise.resolve(res)
            })
            .catch(err => {
                return Promise.reject(err)
            })
        },
        getAssignedAddresses(context, id) {
            let url = process.env.VUE_APP_API_URL + '/employee/assigned-addresses/' + id
            return axios.get(url, {withCredentials: true})
            .then(res => {
                return Promise.resolve(res)
            })
            .catch(err => {
                return Promise.reject(err)
            })
        },
        create(context, form) {
            let url = process.env.VUE_APP_API_URL + '/employee/create'
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
            let url = process.env.VUE_APP_API_URL + '/employee/edit/' + id
            return axios.post(url, form, {withCredentials: true})
            .then(res => {
                return Promise.resolve(res)
            })
            .catch(err => {
                return Promise.reject(err)
            })
        },
        delete(context, id) {
            let url = process.env.VUE_APP_API_URL + '/employee/delete/' + id
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

export default employee
