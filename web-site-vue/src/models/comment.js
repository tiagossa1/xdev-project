import User from "./user";

export default class Comment {
  constructor(comment, postId = null) {
    this.id = comment?.id;
    (this.user = new User(comment?.user)),
      (this.description = comment?.description);
    if (comment.post_id) {
      this.postId = comment?.postId ?? postId;
    }
    if(comment?.user){
      this.user = new User(comment.user)
    }

    this.createdAt = comment?.created_at;
    this.updatedAt = comment?.updated_at;
  }
}
