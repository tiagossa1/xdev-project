<template>
  <b-card-group deck class="mb-3 text-center">
    <b-card
      :style="{
        'border-radius': '10px',
      }"
    >
      <template #header>
        <span class="font-weight-bold">Feed Recente</span>
      </template>
      <b-card-text>
        <div v-if="recentFeed.comments.length > 0">
          <b-row v-for="comment in recentFeed.comments" :key="comment.id">
            <b-col class="text-left">
              <span>
                Comentou <b>{{ comment.description }}</b
                ><br />
                <b-icon class="mr-1" icon="arrow-return-right"></b-icon>
                <small class="font-italic font-weight-bold">{{
                  comment.post.title
                }}</small>
              </span>
              <hr />
            </b-col>
          </b-row>
        </div>

        <div v-if="recentFeed.likes.length > 0">
          <b-row v-for="like in recentFeed.likes" :key="like.id">
            <b-col class="text-left">
              <span>
                Gostou do post <br />

                <b-icon icon="heart-fill" variant="danger"></b-icon>
                <b> {{ like.title }}</b>
              </span>
              <hr />
            </b-col>
          </b-row>
        </div>
      </b-card-text>
    </b-card>
  </b-card-group>
</template>

<script>
export default {
  name: "recent-feed",
  props: { recentFeed: Object },
  components: {},
  data() {
    return {};
  },
};
</script>