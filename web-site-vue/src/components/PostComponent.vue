<template>
    <div class="container">
        <!--<div v-for="post in posts" class="post-container" v-bind:key="post.id">
            <span v-for="tag of tags" class="tags" v-bind:key="tag.name">
                {{tag.name}}
            </span>
            <br>
            <img width="70rem" src="https://cdn-icons-png.flaticon.com/512/147/147144.png" alt="{{}}">
        </div>-->
        <p>s</p>
    </div>
</template>

<script>
export default {
    name: "post-component",
    async mounted(){
        const config = {
            headers: { Authorization: `Bearer 3|M4wxsAQg9kSDrhmmANIrIaEtwO8NGtOOV75kiYDo` }
        };

        let res = await this.axios.get("http://127.0.0.1:8000/api/posts",config);
        this.posts = res.data.data;
        console.log(this.posts);
        //console.log(res);
        
    },
    data() {
        return{
            posts: {},
            /*posts:{
                tags:[
                    {name : 'C#'},
                    {name : 'TS'},
                    {name : 'JS'},
                    {name : 'boostrap'},
                ],
                userInfo:[
                    {name: 'Toni',school_class_id: 'TPSIP',school_id:'ATEC Matosinhos'},
                ],
            },*/
        }
    }
}
</script>

<style>

</style>