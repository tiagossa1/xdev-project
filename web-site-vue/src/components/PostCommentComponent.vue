<template>
  <div>
    <b-card>
      <b-media>
        <template #aside>
          <b-img
            blank
            blank-color="#ccc"
            width="64"
            alt="placeholder"
            class="rounded"
          ></b-img>
        </template>

        <h5
          class="font-weight-bold"
          :style="{ color: comment.user.userType.hexColorCode }"
        >
          {{ comment.user.name }}
        </h5>
        <p>
          {{ comment.description }}
        </p>
      </b-media>
    </b-card>
  </div>
</template>

<script>
import Comment from "../models/comment";

export default {
  name: "post-comment-component",
  props: {
    comment: Comment,
  },
  mounted() {
    //console.log(this.comment);
  },
};
</script>