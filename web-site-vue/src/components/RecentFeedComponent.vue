<template>
    <b-card-group deck class="mb-3 text-center">
    <b-card :style="{backgroundColor: '#dee2e6','border-radius': '25px',border: '2px solid gray',}">
        <template #header >
        <span class="font-weight-bold">Feed Recente</span>
        </template>
        <b-card-text>
            <div v-if="recentFeed.comments.length > 0">
                <b-row v-for="feed in recentFeed.comments" :key="feed.comments" >
                    <b-col class="text-left">
                        <!-- <p :style="{backgroundColor: '#dee2e6',border: '2px solid gray','border-radius': '5px',}" 
                        class="mx-auto p-1">{{feed.user.name}} comentou: '<b>{{feed.description}}</b>' no post (Mostrar titulo do post)</p> -->
                        
                            
                            <!-- <span style="color:black"> comentou: '<b>{{feed.description}}</b>' no post <b>(Mostrar titulo do post)</b></span> -->
                            <span>
                                Comentou <b>{{feed.description}}</b><br>
                                <b-icon icon="arrow-return-right" ></b-icon> <small><b><i> mostrar titulo do post</i></b></small>
                            </span>
                            <hr>
                    </b-col>
                </b-row>
            </div>

            <div v-if="recentFeed.post_likes.length > 0">
                <b-row v-for="feed in recentFeed.post_likes" :key="feed.post_likes" >
                    <b-col class="text-left">
                        <span>
                            Gostou do post<b>{{feed.description}}</b><br>
                            
                            <b-icon icon="heart-fill" variant="danger"></b-icon><small><b><i>{{feed.post.title}}</i></b></small>
                        </span>
                        <hr>
                    </b-col>
                </b-row>
            </div>

        </b-card-text>
    </b-card>
  </b-card-group>
</template>

<script>
export default {
    name: 'recent-feed',
    props: {recentFeed: Object},
    components: {
    },
    data(){
        return{
            
        }
    },
}
</script>

<style>
.yy{
    border: 2px solid gray
}
</style>