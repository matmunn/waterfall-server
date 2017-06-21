
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));
import swal from 'sweetalert2'
import { toastr } from 'Helpers'
import router from './router'
import store from './store'
import moment from 'moment'
import { 
    SET_NOTIFICATION_PERMISSION,
    ADD_TASK,
    DELETE_TASK,
    UPDATE_TASK,
    ADD_NOTE,
    UPDATE_NOTE,
    DELETE_NOTE,
    ADD_USER,
    UPDATE_USER,
    DELETE_USER,
    ADD_CLIENT,
    UPDATE_CLIENT,
    DELETE_CLIENT,
    ADD_CATEGORY,
    UPDATE_CATEGORY,
    DELETE_CATEGORY 
} from '@/store/mutations'

const app = new Vue({
    el: '#app',
    store,
    router,
    created () {
        if ("Notification" in window) {
            window.Notification.requestPermission(perm => {
                this.$store.commit(SET_NOTIFICATION_PERMISSION, perm)
            })
        }

        window.Echo.channel('waterfall')
            .listen('.UpdateAvailable', e => {
                swal({
                    type: 'warning',
                    title: 'Update Available',
                    html: `A new version has been released.<br>
                        You need to refresh to see the changes.<br>
                        <strong>If you don't you might experience errors.</strong><br>
                        Refresh now?`,
                    showCancelButton: true,
                    cancelButtonText: 'Not yet',
                    confirmButtonText: 'Show me the goodness!'
                }).then(() => {
                    window.location.reload()
                }, () => {
                    window.ignoredReload = true
                })
            })
            .listen('.TaskAdded', data => {
                this.$store.commit(ADD_TASK, data.task)
            })
            .listen('.TaskDeleted', data => {
                this.$store.commit(DELETE_TASK, data.taskId)
            })
            .listen('.TaskEdited', data => {
                this.$store.commit(UPDATE_TASK, data.task)
            })
            .listen('.NoteAdded', data => {
                this.$store.commit(ADD_NOTE, data.note)
            })
            .listen('.NoteEdited', data => {
                this.$store.commit(UPDATE_NOTE, data.note)
            })
            .listen('.NoteDeleted', data => {
                this.$store.commit(DELETE_NOTE, data.noteId)
            })
            .listen('.UserAdded', data => {
                this.$store.commit(ADD_USER, data.user)
            })
            .listen('.UserEdited', data => {
                this.$store.commit(UPDATE_USER, data.user)
            })
            .listen('.UserDeleted', data => {
                this.$store.commit(DELETE_USER, data.userId)
            })
            .listen('.CategoryAdded', data => {
                this.$store.commit(ADD_CATEGORY, data.category)
            })
            .listen('.CategoryEdited', data => {
                this.$store.commit(UPDATE_CATEGORY, data.category)
            })
            .listen('.CategoryDeleted', data => {
                this.$store.commit(DELETE_CATEGORY, data.categoryId)
            })
            .listen('.ClientAdded', data => {
                this.$store.commit(ADD_CLIENT, data.client)
            })
            .listen('.ClientEdited', data => {
                this.$store.commit(UPDATE_CLIENT, data.client)
            })
            .listen('.ClientDeleted', data => {
                this.$store.commit(DELETE_CLIENT, data.clientId)
            })
    }
}).$mount("#app");
