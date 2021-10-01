<template>
  <b-container
    :style="{ border: '2px solid gray', 'border-radius': '25px' }"
    class="bv-example-row p-4 ml-4 mb-4"
  >
    <b-row>
      <b-col>
        <span v-for="tag in post.tags" :key="tag.id" class="mr-4">
          <b-badge pill variant="info">{{ tag.name }}</b-badge>
        </span>
      </b-col>
    </b-row>

    <b-row>
      <b-col>
        <b-container>
          <b-row class="justify-content-center">
            <b-avatar
              :src= post.user.profile_picture
              size="5rem"
              :style="{
                border: '3px solid ' + post.user.user_type.hexColorCode,
              }"
            ></b-avatar>
          </b-row>
          <b-row class="justify-content-center mt-1">
            <b-badge
              class="rounded-35 text-center"
              :style="{ backgroundColor: post.user.user_type.hexColorCode }"
            >
              {{ post.user.user_type.name }}
            </b-badge>
          </b-row>
        </b-container>
        <!--Usar Pill-->
      </b-col>
      <b-col cols="10">
        <span
          class="font-weight-bold"
          :style="{ color: post.user.user_type.hexColorCode }"
        >
          {{ post.user.name }}
        </span>
        <br />
        <small>
          {{ post.user.school_class.name }} |
          {{ post.user.school_class.school.name }}</small
        ><br />
        <small>Adicionado {{ post.createdAt }}</small>
      </b-col>
    </b-row>

    <b-row class="mt-3 ml-2">
      <b-col>
        <h3 class="font-weight-bold">{{ post.title }}</h3>
      </b-col>
    </b-row>

    <b-row class="ml-2">
      <b-col>
        <b-icon
          v-on:click="clicked = true"
          v-if="clicked === false"
          icon="heart"
          >Like</b-icon
        >
        <b-icon v-else v-on:click="clicked = false" icon="heart-fill"
          >Like</b-icon
        >
      </b-col>
    </b-row>
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
    return {
      clicked: false,
    };
  },
};
</script>
