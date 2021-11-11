<template>
    <AddressLayout>
        <div class="addressFormContainer">
            <p id="editedAddressTitle" v-if="editedAddress">Successfully edited address</p>
            <div class="inputContainer">
                <label for="street1">Street 1</label>
                <input type="text" id="street1" v-model="form.street1">
                <p class="errMsg" v-if="'street1' in errMsg">{{ errMsg['street1'][0] }}</p>
            </div>
            <div class="inputContainer">
                <label for="street2">Street 2</label>
                <input type="text" id="street2" v-model="form.street2">
                <p class="errMsg" v-if="'street2' in errMsg">{{ errMsg['street2'][0] }}</p>
            </div>
            <div class="inputContainer">
                <label for="postcode">Postcode</label>
                <input type="text" id="postcode" v-model="form.postcode">
                <p class="errMsg" v-if="'postcode' in errMsg">{{ errMsg['postcode'][0] }}</p>
            </div>
            <div class="inputContainer">
                <label for="state">State</label>
                <select id="state" v-model="form.state">
                    <option value="" hidden>Select a state</option>
                    <option :value="state" v-for="(state, i) in states" :key="i">{{state}}</option>
                    <p class="errMsg" v-if="'state' in errMsg">{{ errMsg['state'][0] }}</p>
                </select>
            </div>
            <div class="inputContainer">
                <div v-for="(employee, i) in employees" :key="i" class="assignEmployeesContainer">
                    <input type="checkbox" :value="employee.id" :id="'employee'+employee.id" v-model="form.employees">
                    <label :for="'employee'+employee.id">{{employee.first_name}} {{employee.last_name}}</label>
                </div>
            </div>
            <div class="submitContainer">
                <button @click="edit">Edit Address</button>
            </div>
        </div>
    </AddressLayout>
</template>

<script>
import AddressLayout from '@/components/AddressLayout.vue'

export default {
    components: {
        AddressLayout
    },
    created() {
        this.getEmployees()
        this.getAddress()
        this.getAssignedEmployees()
    },
    data() {
        return {
            states: [
                'johor',
                'kedah',
                'kelantan',
                'melaka',
                'negeri sembilan',
                'pahang',
                'perak',
                'perlis',
                'pulau pinang',
                'sabah',
                'sarawak',
                'selangor',
                'terengganu',
            ],
            editedAddress: false,
            errMsg: {},
            requestedAddressId: '',
            form: {
                street1: '',
                street2: '',
                postcode: '',
                state: '',
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
        getAddress() {
            let addressId = this.$route.params.id

            this.$store.dispatch('address/getOne', addressId)
            .then(res => {
                this.requestedAddressId = res.data.address.id
                this.form.street1 = res.data.address.street1
                this.form.street2 = res.data.address.street2
                this.form.postcode = res.data.address.postcode
                this.form.state = res.data.address.state
            })
            .catch(err => {
                this.errMsg = err.response.data
            })
        },
        getAssignedEmployees() {
            let addressId = this.$route.params.id

            this.$store.dispatch('address/getAssignedEmployees', addressId)
            .then(res => {
                this.form.employees = res.data.employeesIds
            })
            .catch(err => {
                this.errMsg = err.response.data
            })
        },
        edit() {
            this.editedAddress = false
            let form = new FormData()
            form.append('street1', this.form.street1)
            form.append('street2', this.form.street2)
            form.append('postcode', this.form.postcode)
            form.append('state', this.form.state)
            form.append('employees', this.form.employees)

            this.$store.dispatch('address/edit', {'form': form, 'id': this.requestedAddressId})
            .then(() => {
                this.editedAddress = true
            })
            .catch(err => {
                this.errMsg = err.response.data
            })
        }
    }
}
</script>

<style scoped>
#editedAddressTitle {
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