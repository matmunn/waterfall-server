import axios from 'axios'
import { SET_CATEGORIES, ADD_CATEGORY, UPDATE_CATEGORY, DELETE_CATEGORY } from '@/store/mutations'
import { findIndex } from 'lodash'

export default {
    state:{
        categories: []
    },
    actions: {
        getAllCategories ({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/categories').then(response => {
                    if (response.status === 200) {
                        commit(SET_CATEGORIES, response.data)
                        resolve(true)
                    }
                    reject("There was an error")
                }, err => {
                    reject("There was an error")
                })
            })
        },
        addCategory ({ commit }, categoryData) {
            return new Promise((resolve, reject) => {
                axios.post(`/api/category`, categoryData).then(response => {
                    if (response.status === 201) {
                        commit(ADD_CATEGORY, response.data)
                        resolve(true)
                    }
                    reject("There was an error")
                }, () => {
                    reject("There was an error")
                })
            })
        },
        editCategory ({ commit }, categoryData) {
            return new Promise((resolve, reject) => {
                axios.patch(`/api/category/${categoryData.id}`, categoryData).then(response => {
                    if (response.status === 200) {
                        commit(UPDATE_CATEGORY, response.data)
                        resolve(true)
                    }
                    reject("There was an error")
                }, () => {
                    reject("There was an error")
                })
            })
        },
        deleteCategory ({ commit }, categoryId) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/category/${categoryId}`).then(response => {
                    if (response.status === 200) {
                        commit(DELETE_CATEGORY, categoryId)
                        resolve(true)
                    }
                    reject("There was an error")
                }, () => {
                    reject("There was an errro")
                })
            })
        }
    },
    mutations: {
        [SET_CATEGORIES] (state, categories) {
            state.categories = categories
        },
        [ADD_CATEGORY] (state, category) {
            state.categories.push(category)
        },
        [UPDATE_CATEGORY] (state, category) {
            const elmIndex = findIndex(state.categories, x => x.id === category.id)

            state.categories.splice(elmIndex, 1, category)
        },
        [DELETE_CATEGORY] (state, categoryId) {
            state.categories = state.categories.filter(o => o.id !== categoryId)
        }
    },
    getters: {
        categories: state => state.categories,
        category: (state, getters) => (categoryId) => {
            return state.categories.find(category => category.id === categoryId)
        },
        displayCategories: state => state.categories.filter(cat => cat.display_in_list)
    }
}
