<template>
    <div id="navbarContainer">
        <div id="navbarContainer__left">
            <h1>
                <router-link to="/">Case Study</router-link>
            </h1>
        </div>
        <div id="navbarContainer__right">
            <div id="guestContainer" v-if="!isAuthenticated">
                <router-link to="/login">Login</router-link>
                <router-link to="/register">Register</router-link>
            </div>
            <div id="userContainer" v-else>
                <button @click="logout">Logout</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        isAuthenticated() {
            return this.$store.state.isAuthenticated
        }
    },
    methods: {
        logout() {
            this.$store.dispatch('logout')
        }
    }
}
</script>

<style scoped>
#navbarContainer {
    max-width: 1200px;
    margin: auto;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
#navbarContainer__left h1 {
    display: flex;
    align-items: center;
}
#navbarContainer__left h1 a {
    font-size: 18px;
    text-decoration: none;
    color: white;
}
#navbarContainer__right a {
    font-size: 14px;
    color: white;
    text-decoration: none;
    margin-left: 1em;
    letter-spacing: .5px;
}
#navbarContainer__right button {
    font-size: 14px;
    color: white;
    letter-spacing: .5px;
    background-color: transparent;
    border: none;
    transition: all .25s;
    cursor: pointer;
}
#navbarContainer__right button:hover {
    color: red;
}
</style>