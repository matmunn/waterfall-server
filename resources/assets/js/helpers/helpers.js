import store from '@/store'
import toastr from 'toastr'
import axios from 'axios'
import auth from 'Auth'

toastr.options.closeButton = false
toastr.options.timeOut = 2500
toastr.options.extendedTimeOut = 5000

axios.interceptors.request.use(config => {
    config.headers.common['Authorization'] = `Bearer ${auth.getToken()}`

    return config
})

const getCategory = categoryId => {
    return store.getters.category(categoryId) || {}
}

const getUser = userId => {
    return store.getters.user(userId) || {}
}

const getClient = clientId => {
    return store.getters.client(clientId) || {}
}

const getNotes = taskId => {
    return store.getters.taskNotes(taskId) || {}
}

const getTask = taskId => {
    return store.getters.task(taskId) || {}
}

export {
    getUser,
    getClient,
    getNotes,
    getCategory,
    getTask,
    axios,
    toastr
}
