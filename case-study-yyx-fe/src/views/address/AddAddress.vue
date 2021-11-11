<template>
    <AddressLayout>
        <div class="addressFormContainer">
            <p id="createdAddressTitle" v-if="createdAddress">Successfully created address</p>
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
                </select>
                <p class="errMsg" v-if="'state' in errMsg">{{ errMsg['state'][0] }}</p>
            </div>
            <div class="submitContainer">
                <button @click="create">Create Address</button>
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
            createdAddress: false,
            errMsg: {},
            form: {
                street1: '',
                street2: '',
                postcode: '',
                state: '',
            }
        }
    },
    methods: {
        create() {
            this.createdAddress = false
            let form = new FormData()
            form.append('street1', this.form.street1)
            form.append('street2', this.form.street2)
            form.append('postcode', this.form.postcode)
            form.append('state', this.form.state)

            this.$store.dispatch('address/create', form)
            .then(() => {
                this.createdAddress = true
                this.form.street1 = ''
                this.form.street2 = ''
                this.form.postcode = ''
                this.form.state = ''
            })
            .catch(err => {
                this.errMsg = err.response.data
            })
        }
    }
}
</script>

<style scoped>
#createdAddressTitle {
    text-align: center;
    color: var(--persian-green);
}
</style>