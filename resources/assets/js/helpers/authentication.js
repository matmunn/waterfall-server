import moment from 'moment'
import store from '@/store'

export default {
    isLoggedIn () {
        return store.getters.loginStatus
    },
    attemptLogin (email, password) {
        return store.dispatch('attemptLogin', { email, password })
    },
    logout () {
        return store.dispatch('logout')
    },
    getUser () {
        return store.getters.authUser
    },
    getToken () {
        return store.getters.authUser.api_token || ''
    },
    expireInvalidLogins () {
        if (localStorage.getItem('loginExpires') !== null) {
            const expiry = moment(localStorage.getItem('loginExpires'))
            if (expiry < moment()) {
                store.dispatch('logout')
            }
        }
    }
}
