<template>
    <AuthLayout>
        <div class="authFormContainer">
            <div class="inputContainer">
                <label for="email">Email</label>
                <input type="email" id="email" v-model="form.email">
                <p class="errMsg" v-if="'email' in errMsg">{{errMsg['email'][0]}}</p>
            </div>
            <div class="inputContainer">
                <label for="password">Password</label>
                <input type="password" id="password" v-model="form.password">
                <p class="errMsg" v-if="'password' in errMsg">{{errMsg['password'][0]}}</p>
            </div>
            <div class="submitContainer">
                <button @click="login">Sign In</button>
            </div>
            <div class="redirectContainer">
                <router-link to="/register">Register</router-link>
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
                email: '',
                password: '',
            }
        }
    },
    methods: {
        login() {
            let form = new FormData()
            form.append('email', this.form.email)
            form.append('password', this.form.password)

            this.$store.dispatch('login', form)
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