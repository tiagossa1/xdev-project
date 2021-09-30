<template>
  <b-container
    :style="{ 'border': '2px solid gray', 'border-radius': '25px' }"
    class="bv-example-row p-4 ml-4 mb-4"
  >
    <b-row class="p-1">
      <b-col>
        <span v-for="tag in post.tags" :key="tag.id" class="mr-4">
          <b-badge pill variant="info">{{ tag.name }}</b-badge>
        </span>
      </b-col>
    </b-row>

    <b-row>
      <b-col cols="1">
        <img
          class="rounded-circle"
          :style="{'border':'3px solid', color: post.user.user_type.hexColorCode,borderColor:post.user.user_type.hexColorCode }"
          width="70rem"
          fluid
          src="https://cdn-icons-png.flaticon.com/512/147/147144.png"
          alt="xDevIMG"
        />
        <!--Usar Pill-->
        <b-badge variant="info" class="imgLegend rounded-35 w-150 text-center" :style="{ backgroundColor: post.user.user_type.hexColorCode}">
          {{ post.user.user_type.name }}
        </b-badge>
      </b-col>
      <b-col class="ml-2">
        <span> {{ post.user.name }} </span>
        <br />
        <span>
          {{ post.user.school_class.name }} |
          {{ post.user.school_class.school.name }}</span
        ><br />
        <small>Adicionado {{post.createdAt}}</small>
      </b-col>
    </b-row>

    <b-row>
      <b-col>
        <h3 class="font-weight-bold">{{ post.title }}</h3>
      </b-col>
    </b-row>

    <b-row>
      <b-col>
        <b-icon v-on:click="clicked = true" v-if="clicked === false" icon="heart">Like</b-icon>
        <b-icon v-else v-on:click="clicked = false" icon="heart-fill">Like</b-icon>
        
      </b-col>
    </b-row>

    <p></p>
    <p></p>
  </b-container>
</template>

<script>
import Post from "../models/post";

export default {
  name: "post-component",
  props: {
    post: Post,
  },
  data() {
    return{
      clicked : false
    }
    
  }
};
</script>

<style scoped>
</style>
