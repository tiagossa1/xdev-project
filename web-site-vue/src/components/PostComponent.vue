<template>
  <b-container
    :style="{ 'border': '2px solid gray' }"
    class="bv-example-row rounded p-4 ml-4 mb-4"
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
          :style="{ color: post.user.user_type.hexColorCode }"
          width="70rem"
          fluid
          src="https://cdn-icons-png.flaticon.com/512/147/147144.png"
          alt="xDevIMG"
        />
        <!--Usar Pill-->
        <figcaption
          class="imgLegend mx-auto"
          :style="{ backgroundColor: post.user.user_type.hexColorCode }"
        >
          <span class="small">{{ post.user.user_type.name }}</span>
        </figcaption>
      </b-col>
      <b-col>
        <span> {{ post.user.name }} </span>
        <br />
        <span>
          {{ post.user.school_class.name }} |
          {{ post.user.school_class.school.name }}</span
        ><br />
        <small>Adicionado a 10 anos</small>
      </b-col>
    </b-row>

    <b-row>
      <b-col>
        <h3 class="font-weight-bold">{{ post.title }}</h3>
      </b-col>
    </b-row>

    <b-row>
      <b-col>
        <b-icon icon="heart"></b-icon>
        <!-- <b-icon v-else icon="heart-fill"></b-icon> -->
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
};
</script>

<style scoped>
.imgLegend {
  border-radius: 25px;
  width: 55px;
  text-align: center;
}
.post-container {
  background-color: cornflowerblue;
  border-radius: 15px;
}
</style>
