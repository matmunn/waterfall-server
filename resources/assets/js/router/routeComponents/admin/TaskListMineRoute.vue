<template>
<div>
    <div class="text-center space">
        <div class="row">
            <DatePicker :value='startDate' :input-class="datepickerInputClass" @selected='chooseDate2' :wrapper-class='datepickerWrapperClass'></DatePicker>
            to
            <DatePicker :value='endDate' :input-class="datepickerInputClass" @selected='chooseDate2' :wrapper-class='datepickerWrapperClass'></DatePicker>
        </div>
    </div>
    <table>
        <tr>
            <th>
                User
            </th>
            <th>
                Client
            </th>
            <th>
                Task Description
            </th>
            <th>
                Start Time
            </th>
            <th>
                End Time
            </th>
            <th>
                Hours Allotted
            </th>
            <th>
                Task Completed
            </th>
            <th></th>
        </tr>
        <AdminTask v-for="task in taskList" :task="task" :key="task.id" />
    </table>
</div>
</template>

<style scoped>
table {
    margin: 0 auto;
}
.space {
    margin: 20px auto;
}
</style>

<script>
import { mapGetters, mapActions } from 'vuex'
import { sortBy, head } from 'lodash'
import Auth from 'Auth'
import moment from 'moment'
import AdminTask from '@/components/AdminTask'
import DatePicker from 'vuejs-datepicker'

export default {
    name: 'TaskListRoute',
    components: {
        AdminTask,
        DatePicker
    },
    computed: Object.assign({},
        mapGetters(['sortedTasks', 'users']),
        {
            taskList () {
                return sortBy(this.$store.getters.sortedTasksWithDate(this.startDate, this.endDate).filter(task => task.created_by === Auth.getUser().id), ['completed', 'user_id', 'start_time'])
            }
        }
    ),
    data () {
        return {
            startDate: moment().day(1).hour(8).minute(0).format("YYYY-MM-DD"),
            endDate: moment().day(5).hour(18).minute(0).format("YYYY-MM-DD"),
            datepickerInputClass: 'form-control',
            datepickerWrapperClass: 'inline',
            selectedUser: ''
        }
    },
    methods: Object.assign({},
        mapActions(['getAllTasks', 'getAllUsers', 'getAllClients']),
        {
            chooseDate2 (date) {
                this.startDate = moment(date).day(1).format('YYYY-MM-DD')
                this.endDate = moment(date).day(5).hour(18).format('YYYY-MM-DD')
                // console.log(moment(date).day(1).hour(18).toDate())
            }
        }
    ),
    created () {
        this.getAllUsers()
        this.getAllTasks()
        this.getAllClients()
    }
}
</script>
