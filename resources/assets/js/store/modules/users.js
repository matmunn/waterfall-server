import axios from 'axios'
import { SET_USERS, ADD_USER, UPDATE_USER, DELETE_USER } from '@/store/mutations'
import { findIndex } from 'lodash'

export default {
    state:{
        users: []
    },
    actions: {
        getAllUsers ({ commit }, categoryId) {
            return new Promise((resolve, reject) => {
                axios.get(`/api/users`).then(response => {
                    if (response.status === 200) {
                        commit(SET_USERS, response.data)
                        resolve(true)
                    }
                    reject("There was an error")
                }, err => {
                    reject("There was an error")
                })
            })
        },
        addUser ({ commit }, userData) {
            return new Promise((resolve, reject) => {
                axios.post(`/api/user`, userData).then(response => {
                    if (response.status === 201) {
                        commit(ADD_USER, response.data)
                        resolve(true)
                    }
                    reject('There was an error')
                }, () => {
                    reject('There was an error')
                })
            })
        },
        editUser ({ commit }, userData) {
            return new Promise((resolve, reject) => {
                axios.patch(`/api/user/${userData.id}`, userData).then(response => {
                    if (response.status === 200) {
                        commit(UPDATE_USER, userData)
                        resolve(true)
                    }
                    reject('There was an error')
                }, () => {
                    reject('There was an error')
                })
            })
        },
        deleteUser ({ commit }, userId) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/user/${userId}`).then(response => {
                    if (response.status === 200) {
                        commit(DELETE_USER, userId)
                        resolve(true)
                    }
                    reject("There was an error")
                }, () => {
                    reject("There was an error")
                })
            })
        }
    },
    mutations: {
        [SET_USERS] (state, users) {
            state.users = users
        },
        [ADD_USER] (state, user) {
            state.users.push(user)
        },
        [UPDATE_USER] (state, user) {
            const elmIndex = findIndex(state.users, x => x.id === user.id)

            state.users.splice(elmIndex, 1, user)
        },
        [DELETE_USER] (state, userId) {
            state.users = state.users.filter(user => user.id !== userId)
        }
    },
    getters: {
        users: state => state.users,
        categoryUsers: (state, getters) => (category) => {
            return state.users.filter(user => user.category_id === category)
        },
        user: (state, getters) => (userId) => {
            return state.users.find(user => user.id === userId) || {}
        }
    }
}
