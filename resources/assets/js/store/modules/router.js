import { SET_NEXT_ROUTE, CLEAR_NEXT_ROUTE } from '@/store/mutations'

export default {
    state: {
        nextRoute: null
    },
    mutations: {
        [SET_NEXT_ROUTE] (state, route) {
            state.nextRoute = route
        },
        [CLEAR_NEXT_ROUTE] (state) {
            state.nextRoute = null
        }
    },
    getters: {
        nextRoute: state => state.nextRoute
    }
}
