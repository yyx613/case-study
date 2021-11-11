<template>
    <AuthLayout>
        <div class="authFormContainer">
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
            <div class="inputContainer">
                <label for="password">Password</label>
                <input type="password" id="password" v-model="form.password">
                <p class="errMsg" v-if="'password' in errMsg">{{ errMsg['password'][0] }}</p>
            </div>
            <div class="inputContainer">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" v-model="form.password_confirmation">
                <p class="errMsg" v-if="'password_confirmation' in errMsg">{{ errMsg['password_confirmation'][0] }}</p>
            </div>
            <div class="submitContainer">
                <button @click="register">Sign Up</button>
            </div>
            <div class="redirectContainer">
                <router-link to="/login">Login</router-link>
            </div>
        </div>
    </AuthLayout>
</template>

<script>
import AuthLayout from '@/components/AuthLayout.vue'

export default {
    components: {
        AuthLayout
    },
    data() {
        return {
            errMsg: {},
            form: {
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirmation: '',
            }
        }
    },
    methods: {
        register() {
            let form = new FormData()
            form.append('first_name', this.form.first_name)
            form.append('last_name', this.form.last_name)
            form.append('email', this.form.email)
            form.append('password', this.form.password)
            form.append('password_confirmation', this.form.password_confirmation)

            this.$store.dispatch('register', form)
            .then(() => {
                this.$router.push('/')
            })
            .catch(err => {
                this.errMsg = err.response.data
            })
        }
    }
}
</script>

<style scoped>
</style>