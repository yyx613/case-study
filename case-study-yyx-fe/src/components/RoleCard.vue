<template>
    <div id="roleCardContainer">
        <div id="roleCardContainer__body">
            <p>{{role.title}}</p>
            <div id="roleFuncContainer">
                <router-link :to="'/edit-role/' + role.id">Edit</router-link>
                <button @click="deleterole">Delete</button>
            </div>
        </div>
        <div id="roleCardContainer__bottom">
            <h4 class="employeeTitle">Employees</h4>
            <p class="roleEmployee" v-for="(employee, i) in role.employees" :key="i">
                {{employee.first_name}}<br>
                {{employee.last_name}}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        role: {
            type: Object
        }
    },
    methods: {
        deleterole() {
            this.$store.dispatch('role/delete', this.role.id)
            .then(() => {
                this.$store.dispatch('role/getAll')
            })
        }
    }
}
</script>

<style scoped>
#roleCardContainer {
    display: grid;
    row-gap: 1em;
    background-color: white;
    border: solid 1px #ddd;
    border-radius: 5px;
    overflow: hidden;
    padding: .75em;
}
#roleCardContainer p {
    font-size: 14px;
    color: grey;
}
#roleFuncContainer {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    column-gap: 2em;
    align-items: center;
    margin: 0.75em 0;
}
#roleFuncContainer a,
#roleFuncContainer button {
    border: none;
    border-radius: 5px;
    font-weight: bold;
    letter-spacing: .5px;
    cursor: pointer;
    font-size: 12px;
    text-decoration: none;
    text-align: center;
    background-color: transparent;
}
#roleFuncContainer a {
    color: var(--ultramarine-blue);
}
#roleFuncContainer button {
    color: red;
}
.employeeTitle {
    font-size: 14px;
    border-top: solid 1px #ddd;
    padding-top: .75em;
    margin: .75em 0;
}
.roleEmployee {
    font-size: 14px;
    color: grey;
    margin-bottom: .75em;
    padding-left: .5em;
    border-left: solid 3px var(--persian-green);
}
</style>