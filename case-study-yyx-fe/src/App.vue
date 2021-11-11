<template>
  <div id="mainLayout">
    <div id="mainLayout__navbar">
      <Navbar/>
    </div>
    <div id="mainLayout__content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Navbar from '@/components/Navbar.vue'

export default {
  components: {
    Navbar
  },
  created() {
    this.autoLogin()
  },
  methods: {
    autoLogin() {
      if(localStorage.getItem('autoLogin') != null) {
        let form = new FormData()
        form.append('id', localStorage.getItem('autoLogin'))

        this.$store.dispatch('autoLogin', form)
      }
    }
  }
}
</script>

<style>
:root {
  --ultramarine-blue: #4361EE;
  --persian-green: #2A9D8F;
  --sandy-brown: #F4A261;
}
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  font-family: sans-serif;
  outline: none;
}
#mainLayout {
  display: grid;
  grid-template-rows: 55px 1fr;
  min-height: 100vh;
  background-color: #eeeeee50;
}
#mainLayout__navbar {
  background-color: var(--persian-green);
}
</style>
