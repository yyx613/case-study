<template>
    <div id="addressLayout">
        <div id="addressLayout__header">
            <h6>{{formTitle}}</h6>
        </div>
        <div id="addressLayout__body">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        formTitle() {
            switch (this.$route.name) {
                case 'AddAddress':
                    return 'Create an address'
                case 'EditAddress':
                    return 'Edit Address'
                default:
                    return 'No Title'
            }
        }
    }
}
</script>

<style scoped>
#addressLayout {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
#addressLayout__header {
    margin-bottom: 1em;
}
#addressLayout__header h6 {
    font-size: 2em;
    letter-spacing: .5px;
    text-transform: capitalize;
    color: var(--persian-green);
}
#addressLayout__body {
    width: 100%;
}
/* slot css */
.addressFormContainer {
    background-color: white;
    border: solid 1px #eee;
    border-radius: 5px;
    padding: 1.5em;
    width: 100%;
    max-width: 450px;
    margin: auto;
}
.inputContainer {
    margin: 1em 0;
}
.inputContainer label {
    font-size: 14px;
    padding-left: .25em;
    letter-spacing: .5px;
}
.inputContainer .errMsg {
    font-size: 14px;
    padding-left: .25em;
    color: red;
}
.inputContainer input {
    padding: .75em;
    border: solid 1px #ddd;
    border-radius: 5px;
    width: 100%;
}
.inputContainer select {
    padding: .75em;
    border: solid 1px #ddd;
    border-radius: 5px;
    width: 100%;
    text-transform: capitalize;
}
.submitContainer button {
    padding: .75em 0;
    border: none;
    border-radius: 5px;
    width: 100%;
    background-color: var(--persian-green);
    font-weight: bold;
    letter-spacing: .5px;
    cursor: pointer;
    transition: all .25s;
    color: white;
}
.submitContainer button:hover {
    opacity: .85;
}
.redirectContainer {
    margin-top: 1em;
    display: flex;
    justify-content: flex-end;
}
.redirectContainer a {
    font-size: 14px;
    text-decoration: none;
    letter-spacing: .5px;
}
</style>