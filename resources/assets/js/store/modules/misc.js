import { SET_NOTIFICATION_PERMISSION } from '@/store/mutations'

export default {
    state: {
        notificationPermission: false
    },
    mutations: {
        [SET_NOTIFICATION_PERMISSION] (state, permission) {
            state.notificationPermission = permission
        }
    },
    getters: {
        notificationPermission: state => state.notificationPermission
    }
}
