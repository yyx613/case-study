<template>
    <div id="addressCardContainer">
        <div id="addressCardContainer__body">
            <p>{{address.street1}}</p>
            <p>{{address.street2}}</p>
            <p>{{address.postcode}}</p>
            <p>{{address.state}}</p>
            <div id="addressFuncContainer">
                <router-link :to="'/edit-address/' + address.id">Edit</router-link>
                <button @click="deleteAddress">Delete</button>
            </div>
        </div>
        <div id="addressCardContainer__bottom">
            <h4 class="employeeTitle">Employees</h4>
            <p class="addressEmployee" v-for="(employee, i) in address.employees" :key="i">
                {{employee.first_name}}<br>
                {{employee.last_name}}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        address: {
            type: Object
        }
    },
    methods: {
        deleteAddress() {
            this.$store.dispatch('address/delete', this.address.id)
            .then(() => {
                this.$store.dispatch('address/getAll')
            })
        }
    }
}
</script>

<style scoped>
#addressCardContainer {
    display: grid;
    row-gap: 1em;
    background-color: white;
    border: solid 1px #ddd;
    border-radius: 5px;
    overflow: hidden;
    padding: .75em;
}
#addressCardContainer p {
    font-size: 14px;
    color: grey;
}
#addressFuncContainer {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    column-gap: 2em;
    align-items: center;
    margin: 0.75em 0;
}
#addressFuncContainer a,
#addressFuncContainer button {
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
#addressFuncContainer a {
    color: var(--ultramarine-blue);
}
#addressFuncContainer button {
    color: red;
}
.employeeTitle {
    font-size: 14px;
    border-top: solid 1px #ddd;
    padding-top: .75em;
    margin: .75em 0;
}
.addressEmployee {
    font-size: 14px;
    color: grey;
    margin-bottom: .75em;
    padding-left: .5em;
    border-left: solid 3px var(--persian-green);
}
</style>