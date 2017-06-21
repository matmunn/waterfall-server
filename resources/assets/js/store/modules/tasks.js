import { axios } from 'Helpers'
import moment from 'moment'
import { SET_TASKS, ADD_TASK, UPDATE_TASK, DELETE_TASK, SET_TASK_COMPLETE_STATUS } from '@/store/mutations'
import { sortBy, findIndex } from 'lodash'

export default {
    state:{
        tasks: []
    },
    actions: {
        getAllTasks ({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/tasks').then(response => {
                    if (response.status === 200) {
                        commit(SET_TASKS, response.data)
                        resolve(response.data.length)
                    }
                    reject(response)
                }, err => {
                    reject(err)
                })
            })
        },
        getTasksBetweenDates ({ commit }, dateRange = {start: moment().day(1).format("YYYY-MM-DD"), end: moment().day(5).format("YYYY-MM-DD")}) {
            return new Promise((resolve, reject) => {
                axios.get(`/api/tasks/${dateRange.start}/${dateRange.end}`).then(response => {
                    if (response.status === 200) {
                        commit(SET_TASKS, response.data)
                        resolve(response.data.length)
                    }
                    reject('There was an error')
                }, () => {
                    reject('There was an error')
                })
            })
        },
        markTaskComplete({ commit }, taskId) {
            return new Promise((resolve, reject) => {
                axios.patch(`/api/task/${taskId}/complete`).then(response => {
                    if (response.status === 200) {
                        // commit(SET_TASK_COMPLETE_STATUS, {taskId, status: true})
                        resolve(true)
                    }
                    reject("There was an error")
                }, () => {
                    reject("There was an error")
                })
            })
        },
        markTaskIncomplete({ commit }, taskId) {
            return new Promise((resolve, reject) => {
                axios.patch(`/api/task/${taskId}/incomplete`).then(response => {
                    if (response.status === 200) {
                        // commit(SET_TASK_COMPLETE_STATUS, {taskId, status: false})
                        resolve(true)
                    }
                    reject("There was an error")
                }, () => {
                    reject("There was an error")
                })
            })
        },
        addTask({ commit }, taskData) {
            return new Promise((resolve, reject) => {
                axios.post('/api/task', taskData).then(response => {
                    if (response.status === 201) {
                        resolve(true)
                    }
                    reject(response)
                }, err => {
                    reject(err.response.data)
                })
            })
        },
        editTask({ commit }, taskData) {
            return new Promise((resolve, reject) => {
                axios.patch(`/api/task/${taskData.id}`, taskData).then(response => {
                    if (response.status === 200) {
                        resolve(true)
                    }
                    reject(response)
                }, err => {
                    reject(err.response.data)
                })
            })
        },
        deleteTask ({ commit }, taskId) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/task/${taskId}`).then(response => {
                    if (response.status === 200) {
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
        [SET_TASKS] (state, tasks) {
            state.tasks = tasks
        },
        [ADD_TASK] (state, task) {
            state.tasks.push(task)
        },
        [UPDATE_TASK] (state, task) {
            const elmIndex = findIndex(state.tasks, x => x.id === task.id)
            
            state.tasks.splice(elmIndex, 1, task)
        },
        [DELETE_TASK] (state, taskId) {
            state.tasks = state.tasks.filter(task => task.id !== taskId)
        },
        [SET_TASK_COMPLETE_STATUS] (state, {taskId, status}) {
            let task = state.tasks.find(task => task.id === taskId)
            if (task !== undefined) {
                task.completed = status
            }
        }
    },
    getters: {
        tasks: state => state.tasks,
        task: (state, getters) => (taskId) => {
            return state.tasks.find(task => task.id === taskId)
        },
        sortedTasks: state => {
            return sortBy(state.tasks, ['completed', 'start_date'])
        },
        userTasks: (state, getters) => (userId, startDate, endDate) => {
            return getters.sortedTasksWithDate(startDate, endDate).filter(task => {
                return task.user_id === userId
            })
        },
        sortedTasksWithDate: (state, getters) => (startDate, endDate) => {
            return getters.sortedTasks.filter(task => {
                const startTimeMatch = (moment(task.start_date) >= moment(startDate))
                const endTimeMatch = (moment(task.end_date) <= moment(endDate).hour(18).minute(0))
                return startTimeMatch && endTimeMatch
            })
        }
    }
}
