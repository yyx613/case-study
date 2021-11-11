<template>
    <EmployeeLayout>
        <div class="employeeFormContainer">
            <p id="createdEmployeeTitle" v-if="createdEmployee">Successfully created employee</p>
            <div class="inputContainer">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" v-model="form.first_name">
                <p class="errMsg" v-if="'first_name' in errMsg">{{ errMsg['first_name'][0] }}</p>
            </div>
            <div class="inputContainer">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" v-model="form.last_name">
                <p class="errMsg" v-if="'last_name' in errMsg">{{ errMsg['last_name'][0] }}</p>
            </div>
            <div class="inputContainer">
                <label for="email">Email</label>
                <input type="email" id="email" v-model="form.email">
                <p class="errMsg" v-if="'email' in errMsg">{{ errMsg['email'][0] }}</p>
            </div>
            <div class="submitContainer">
                <button @click="create">Create Employee</button>
            </div>
        </div>
    </EmployeeLayout>
</template>

<script>
import EmployeeLayout from '@/components/EmployeeLayout.vue'

export default {
    components: {
        EmployeeLayout
    },
    data() {
        return {
            createdEmployee: false,
            errMsg: {},
            form: {
                first_name: '',
                last_name: '',
                email: '',
            }
        }
    },
    methods: {
        create() {
            this.createdEmployee = false
            let form = new FormData()
            form.append('first_name', this.form.first_name)
            form.append('last_name', this.form.last_name)
            form.append('email', this.form.email)

            this.$store.dispatch('employee/create', form)
            .then(() => {
                this.createdEmployee = true
                this.form.first_name = ''
                this.form.last_name = ''
                this.form.email = ''
            })
            .catch(err => {
                this.errMsg = err.response.data
            })
        }
    }
}
</script>

<style scoped>
#createdEmployeeTitle {
    text-align: center;
    color: var(--persian-green);
}
</style>