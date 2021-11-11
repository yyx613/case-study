<template>
    <RoleLayout>
        <div class="roleFormContainer">
            <p id="editedRoleTitle" v-if="editedRole">Successfully edited role</p>
            <div class="inputContainer">
                <label for="title">Title</label>
                <input type="text" id="title" v-model="form.title">
                <p class="errMsg" v-if="'title' in errMsg">{{ errMsg['title'][0] }}</p>
            </div>
            <div class="inputContainer">
                <div v-for="(employee, i) in employees" :key="i" class="assignEmployeesContainer">
                    <input type="checkbox" :value="employee.id" :id="'employee'+employee.id" v-model="form.employees">
                    <label :for="'employee'+employee.id">{{employee.first_name}} {{employee.last_name}}</label>
                </div>
            </div>
            <div class="submitContainer">
                <button @click="edit">Edit Role</button>
            </div>
        </div>
    </RoleLayout>
</template>

<script>
import RoleLayout from '@/components/RoleLayout.vue'

export default {
    components: {
        RoleLayout
    },
    created() {
        this.getEmployees()
        this.getRole()
        this.getAssignedEmployees()
    },
    data() {
        return {
            editedRole: false,
            errMsg: {},
            requestedroleId: '',
            form: {
                title: '',
                employees: []
            }
        }
    },
    computed: {
      employees() {
        return this.$store.state.employee.employees
      },
    },
    methods: {
        getEmployees() {
            this.$store.dispatch('employee/getAll')
        },
        getRole() {
            let roleId = this.$route.params.id

            this.$store.dispatch('role/getOne', roleId)
            .then(res => {
                this.requestedroleId = res.data.role.id
                this.form.title = res.data.role.title
            })
            .catch(err => {
                this.errMsg = err.response.data
            })
        },
        getAssignedEmployees() {
            let roleId = this.$route.params.id

            this.$store.dispatch('role/getAssignedEmployees', roleId)
            .then(res => {
                this.form.employees = res.data.employeesIds
            })
            .catch(err => {
                this.errMsg = err.response.data
            })
        },
        edit() {
            this.editedRole = false
            let form = new FormData()
            form.append('title', this.form.title)
            form.append('employees', this.form.employees)

            this.$store.dispatch('role/edit', {'form': form, 'id': this.requestedroleId})
            .then(() => {
                this.editedRole = true
            })
            .catch(err => {
                this.errMsg = err.response.data
            })
        }
    }
}
</script>

<style scoped>
#editedRoleTitle {
    text-align: center;
    color: var(--persian-green);
}
.assignEmployeesContainer {
    display: grid;
    grid-template-columns: 25px 1fr;
    margin-bottom: .5em;
}
.assignEmployeesContainer input {
    margin-top: .25em;
}
</style>