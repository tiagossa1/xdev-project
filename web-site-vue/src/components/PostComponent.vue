<template>
  <div class="container">
    <br>
    <div v-for="post in posts" class="post-container mt-3" :key="post.id">
      <!--<span v-for="tag of tags" class="tags" v-bind:key="tag.name">
          {{tag.name}}
      </span>-->
      <b-container class="bv-example-row p-2 ml-4">

        <b-row class="p-1" >
          <b-col>
            <span v-for="tag in post.tags" :key="tag.id" class="mr-4" >
              <b-badge pill variant="info">{{tag.name}}</b-badge>
            </span>
          </b-col>
        </b-row>

        <b-row>
          <b-col cols="1">
            <img class="rounded-circle" :style="{border: imgStyle.styleImg,color:imgStyle.hexColor}" width="70rem" fluid src="https://cdn-icons-png.flaticon.com/512/147/147144.png" alt="xDevIMG">
              <!--Usar Pill-->
              <figcaption class="imgLegend mx-auto" :style="{backgroundColor:imgStyle.hexColor}">xDev</figcaption>
          </b-col>
          <b-col>
            <span>Toni</span><br>
            <span>TPSIP 10.20 | ATEC Palmela</span><br>
            <small>Adicionado a 10 anos</small>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <h3 class="font-weight-bold">{{post.title}}</h3>
          </b-col>
        </b-row>

        <b-row>
          <b-col>
            <b-icon v-on:click="liked = true" v-if="liked == false" icon="heart"></b-icon>
            <b-icon v-else icon="heart-fill"></b-icon>
          </b-col>
        </b-row>

        <p></p><p></p>
      </b-container>
    </div>
  </div>
</template>

<script>
import postService from "../services/postService";

export default {
  name: "post-component",
  created(){
    postService
      .getPosts()
      .then(
        (res) => {
          (this.posts = res.data.data.filter(x => x.suspended === 0 ))
          console.log(this.posts)
        }
    ).catch(err => console.log(err))

  },
  data() {
    return {
      posts: [],
      liked: false,
      imgStyle: {
        hexColor: '#31dde1',
        //colorFromUser:`${post.hex}`,
        borderRadius: '50%',
        styleImg: '3px solid',
      },
      
    };
  },
  computed: {
    /*getAllTags(){
      return this.tags.map(x =>x.name).join(', ')
    }*/
  }
};
</script>

<style scoped>
.imgLegend{
  border-radius: 25px;
  width: 55px;
  text-align: center;
  /*margin-top: -15px;*/
}
.post-container{
  background-color: cornflowerblue;
  border-radius: 15px;
}
</style>
