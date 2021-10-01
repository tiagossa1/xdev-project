<template>
    <!--{{this.$store.getters['auth/user'].email}}-->
    <user-card-component></user-card-component>
</template>

<script>
import UserCardComponent from "../components/UserCardComponent.vue";
export default {
    name: "Profile",
    components: { UserCardComponent },
    data() {
        return {

        };
    },
}
</script>

<style>

</style>