<template>
<!--:img-src="this.$store.getters['auth/user'].profile_picture"-->
    <div>
       <b-card
        no-body
        img-src="https://picsum.photos/600/300/?image=25"
        :img-alt="this.$store.getters['auth/user'].name +` photo`"  
        img-top
        tag="article"
        style="max-width: 20rem;"
        class="mb-2"
        >
            <b-card-body>
                <b-card-title>{{this.$store.getters['auth/user'].user_type}}</b-card-title>
                <b-card-sub-title class="mb-2">Card Sub Title</b-card-sub-title>
                <b-card-text>
                    Some quick example text to build on the card title and make up the bulk of the card's
                    content.
                </b-card-text>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import userService from "../services/userService";
export default {
    name: "user-card-component",
    data(){
        return {

        };
    },
    created(){
        userService.getUserById(this.$store.getters['auth/user'].id)
    }
}
</script>

<style>

</style>