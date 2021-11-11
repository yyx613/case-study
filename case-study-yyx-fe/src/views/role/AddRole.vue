<template>
    <RoleLayout>
        <div class="roleFormContainer">
            <p id="createdRoleTitle" v-if="createdRole">Successfully created role</p>
            <div class="inputContainer">
                <label for="title">Title</label>
                <input type="text" id="title" v-model="form.title">
                <p class="errMsg" v-if="'title' in errMsg">{{ errMsg['title'][0] }}</p>
            </div>
            <div class="submitContainer">
                <button @click="create">Create Role</button>
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
    data() {
        return {
            createdRole: false,
            errMsg: {},
            form: {
                title: '',
            }
        }
    },
    methods: {
        create() {
            this.createdRole = false
            let form = new FormData()
            form.append('title', this.form.title)

            this.$store.dispatch('role/create', form)
            .then(() => {
                this.createdRole = true
                this.form.title = ''
            })
            .catch(err => {
                this.errMsg = err.response.data
            })
        }
    }
}
</script>

<style scoped>
#createdRoleTitle {
    text-align: center;
    color: var(--persian-green);
}
</style>