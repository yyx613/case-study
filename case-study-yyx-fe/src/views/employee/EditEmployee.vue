<template>
    <EmployeeLayout>
        <div class="employeeFormContainer">
            <p id="editedEmployeeTitle" v-if="editedEmployee">Successfully edited employee</p>
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
                <input type="email" id="email" v-model="form.email" class="disabledInput">
                <p class="errMsg" v-if="'email' in errMsg">{{ errMsg['email'][0] }}</p>
            </div>
            <div class="inputContainer">
                <div v-for="(address, i) in addresses" :key="i" class="assignAddressContainer">
                    <input type="checkbox" :value="address.id" :id="'address'+address.id" v-model="form.addresses">
                    <label :for="'address'+address.id">
                        {{address.street1}}<br>
                        {{address.street2}}<br>
                        {{address.postcode}}<br>
                        {{address.state}}
                    </label>
                </div>
            </div>
            <div class="submitContainer">
                <button @click="edit">Edit Employee</button>
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
    created() {
        this.getAddresses()
        this.getEmployee()
        this.getAssignedAddresses()
    },
    data() {
        return {
            editedEmployee: false,
            errMsg: {},
            form: {
                first_name: '',
                last_name: '',
                email: '',
                addresses: [],
            },
        }
    },
    computed: {
        addresses() {
            return this.$store.state.address.addresses
        },
    },
    methods: {
        getAddresses() {
            this.$store.dispatch('address/getAll')
        },
        getEmployee() {
            let employeeId = this.$route.params.id

            this.$store.dispatch('employee/getOne', employeeId)
            .then(res => {
                this.form.first_name = res.data.employee.first_name
                this.form.last_name = res.data.employee.last_name
                this.form.email = res.data.employee.email
            })
            .catch(err => {
                this.errMsg = err.response.data
            })
        },
        getAssignedAddresses() {
            let employeeId = this.$route.params.id

            this.$store.dispatch('employee/getAssignedAddresses', employeeId)
            .then(res => {
                this.form.addresses = res.data.addressesIds
            })
            .catch(err => {
                this.errMsg = err.response.data
            })
        },
        edit() {
            this.editedEmployee = false
            let form = new FormData()
            form.append('first_name', this.form.first_name)
            form.append('last_name', this.form.last_name)
            form.append('addresses', this.form.addresses)

            this.$store.dispatch('employee/edit', {'form': form, 'id': this.$route.params.id})
            .then(() => {
                this.editedEmployee = true
            })
            .catch(err => {
                this.errMsg = err.response.data
            })
        }
    }
}
</script>

<style scoped>
#editedEmployeeTitle {
    text-align: center;
    color: var(--persian-green);
}
.assignAddressContainer {
    display: grid;
    grid-template-columns: 25px 1fr;
    margin-bottom: .5em;
}
.assignAddressContainer input {
    margin-top: .25em;
}
.disabledInput {
    background-color: #ddd;
    pointer-events: none;
}
</style>