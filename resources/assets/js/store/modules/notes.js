import { SET_NOTES, ADD_NOTE, UPDATE_NOTE, DELETE_NOTE } from '@/store/mutations'
import { findIndex } from 'lodash'
import { axios} from 'Helpers'

export default {
    state:{
        notes: []
    },
    actions: {
        getAllNotes ({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/notes').then(response => {
                    if (response.status === 200) {
                        commit(SET_NOTES, response.data)
                        resolve(response.data.length)
                    }
                    reject("There was an error")
                }, err => {
                    reject("There was an error")
                })
            })
        },
        addNote ({ commit }, noteData) {
            return new Promise((resolve, reject) => {
                axios.post(`/api/note`, noteData).then(response => {
                    if (response.status === 201) {
                        // commit(ADD_NOTE, response.data)
                        resolve(true)
                    }
                    reject("There was an error")
                }, () => {
                    reject("There was an error")
                })
            })
        },
        editNote ({ commit }, noteData) {
            return new Promise((resolve, reject) => {
                axios.patch(`/api/note/${noteData.id}`, noteData).then(response => {
                    if (response.status === 200) {
                        // commit(UPDATE_NOTE, response.data)
                        resolve(true)
                    }
                    reject("There was an error")
                }, () => {
                    reject("There was an error")
                })
            })
        },
        deleteNote ({ commit }, noteId) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/note/${noteId}`).then(response => {
                    if (response.status === 200) {
                        // commit(DELETE_NOTE, noteId)
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
        [SET_NOTES] (state, notes) {
            state.notes = notes
        },
        [ADD_NOTE] (state, note) {
            state.notes.unshift(note)
        },
        [UPDATE_NOTE] (state, note) {
            const elmIndex = findIndex(state.note, x => x.id === note.id)

            state.notes.splice(elmIndex, 1, note)
        },
        [DELETE_NOTE] (state, noteId) {
            state.notes = state.notes.filter(note => note.id !== noteId)
        }
    },
    getters: {
        notes: state => state.notes,
        taskNotes: (state, getters) => (taskId) => {
            return state.notes.filter(note => note.entry_id === taskId)
        }
    }
}
