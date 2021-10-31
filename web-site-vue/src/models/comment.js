import Post from "./post";
import User from "./user";

import dayjs from "dayjs";

export default class Comment {
  constructor(comment, postId = null) {
    this.id = comment?.id;
    (this.user = new User(comment?.user)),
      (this.description = comment?.description);

    if (comment.post_id) {
      this.postId = comment?.postId ?? postId;
    }

    if (comment?.user) {
      this.user = new User(comment.user)
    }

    if (comment?.post) {
      this.post = new Post(comment.post);
    }

    // this.createdAt = comment?.created_at;
    this.createdAt = dayjs(dayjs(comment?.created_at)).fromNow();
    this.updatedAt = comment?.updated_at;
  }
}
