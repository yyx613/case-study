<template>
  <div id="homeLayout">
    <div id="homeLayout__header">
      <div id="homeLayout__header__left">
        <router-link to="/add-employee">Add Employee</router-link>
        <router-link to="/add-address">Add Address</router-link>
        <router-link to="/add-roles">Add Role</router-link>
      </div>
      <div id="homeLayout__header__right">
        <div id="filterContainer">
          <input type="text" placeholder="Filter employee by address" v-model="filterKeyword">
          <button @click="filter">search</button>
        </div>
      </div>
    </div>
    <div id="homeLayout__body">
      <h6>Employees</h6>
      <div class="cardListContainer">
        <EmployeeCard v-for="(employee, i) in employees" :key="i" :employee="employee" />
      </div>
      <h6>Deleted Employees</h6>
      <div class="cardListContainer">
        <EmployeeCard v-for="(employee, i) in deletedEmployees" :key="i" :employee="employee" />
      </div>
      <h6>Addresses</h6>
      <div class="cardListContainer">
        <AddressCard v-for="(address, i) in addresses" :key="i" :address="address" />
      </div>
      <h6>Roles</h6>
      <div class="cardListContainer">
        <RoleCard v-for="(role, i) in roles" :key="i" :role="role" />
      </div>
    </div>
  </div>
</template>

<script>
import EmployeeCard from '@/components/EmployeeCard.vue'
import AddressCard from '@/components/AddressCard.vue'
import RoleCard from '@/components/RoleCard.vue'

export default {
  components: {
    EmployeeCard,
    AddressCard,
    RoleCard,
  },
  created() {
    this.getEmployees()
    this.getDeletedEmployees()
    this.getAddresses()
    this.getRoles()
  },
  data() {
    return {
      filterKeyword: ''
    }
  },
  computed: {
      employees() {
        return this.$store.state.employee.employees
      },
      deletedEmployees() {
        return this.$store.state.employee.deletedEmployees
      },
      addresses() {
        return this.$store.state.address.addresses
      },
      roles() {
        return this.$store.state.role.roles
      },
  },
  methods: {
    filter() {
      this.$store.dispatch('employee/getAll', this.filterKeyword)
    },
    getEmployees() {
      this.$store.dispatch('employee/getAll')
    },
    getDeletedEmployees() {
      this.$store.dispatch('employee/getAllDeleted')
    },
    getAddresses() {
      this.$store.dispatch('address/getAll')
    },
    getRoles() {
      this.$store.dispatch('role/getAll')
    },
  }
}
</script>

<style scoped>
#homeLayout {
  height: 100%;
  max-width: 1200px;
  margin: auto;
  display: grid;
  grid-template-rows: 55px 1fr;
  row-gap: 1em;
  padding: 1em 0;
}
#homeLayout__header {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  column-gap: 2em;
  align-items: center;
}
#homeLayout__header__left a {
  font-size: 14px;
  text-decoration: none;
  padding: .5em;
  border-radius: 5px;
  border: none;
  margin-right: .5em;
  cursor: pointer;
  background-color: var(--sandy-brown);
  color: black;
  letter-spacing: .5px;
}
#homeLayout__header__right {
  display: flex;
  justify-content: flex-end;
}
#filterContainer {
  display: flex;
  border-radius: 5px;
  overflow: hidden;
}
#filterContainer input {
  border-radius: 5px 0 0 5px;
  padding: .5em .75em;
  border: solid 1px #ddd;
  width: 100%;
}
#filterContainer button {
  background-color: var(--sandy-brown);
  border: none;
  padding: 0 .5em;
  cursor: pointer;
}
#homeLayout__body h6 {
  font-size: 16px;
  color: var(--persian-green);
  letter-spacing: .5px;
  margin: .75em .5em;
}
.cardListContainer {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  column-gap: 1em;
}
</style>