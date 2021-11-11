<template>
    <div id="employeeCardContainer" :class="[employee.deleted ? 'deleted': '']">
        <div id="employeeCardContainer__body">
            <h2 class="employeeName">{{employee.first_name}} {{employee.last_name}}</h2>
            <h3 class="employeeEmail">{{employee.email}}</h3>
            <div id="employeeFuncContainer" v-if="!employee.deleted">
                <router-link :to="'/edit-employee/' + employee.id">Edit</router-link>
                <button @click="deleteEmployee">Delete</button>
            </div>
            <h4 class="employeeAddressTitle">Addresses</h4>
            <p class="employeeAddress" v-for="(address, i) in employee.addresses" :key="i">
                {{address.street1}}<br>
                {{address.street2}}<br>
                {{address.postcode}}<br>
                {{address.state}}<br>
            </p>
            <h4 class="employeeAddressTitle">Roles</h4>
            <p class="employeeAddress" v-for="(role, i) in employee.roles" :key="i">
                {{role.title}}<br>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        employee: {
            type: Object
        }
    },
    methods: {
        deleteEmployee() {
            this.$store.dispatch('employee/delete', this.employee.id)
            .then(() => {
                this.$store.dispatch('employee/getAll')
                this.$store.dispatch('employee/getAllDeleted')
            })
        }
    }
}
</script>

<style scoped>
#employeeCardContainer {
    background-color: white;
    border: solid 1px #ddd;
    border-radius: 5px;
    overflow: hidden;
}
.deleted {
    background-color: #dddddd70!important;
}
#employeeFuncContainer {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    column-gap: 2em;
    align-items: center;
    margin: .75em 0;
}
#employeeFuncContainer a,
#employeeFuncContainer button {
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
#employeeFuncContainer a {
    color: var(--ultramarine-blue);
}
#employeeFuncContainer button {
    color: red;
}
#employeeCardContainer__body {
    padding: .75em;
}
#employeeCardContainer__body .employeeName {
    font-size: 16px;
}
#employeeCardContainer__body .employeeEmail {
    margin-top: .25em;
    font-size: 14px;
    font-weight: lighter;
    color: grey;
}
#employeeCardContainer__body .employeeAddressTitle {
    font-size: 14px;
    border-top: solid 1px #ddd;
    padding-top: .75em;
    margin: .75em 0;
}
#employeeCardContainer__body .employeeAddress {
    font-size: 14px;
    color: grey;
    margin-bottom: .75em;
    padding-left: .5em;
    border-left: solid 3px var(--persian-green);
}
</style>