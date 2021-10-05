export default class CommentRequest {
  constructor(description, userId, postId) {
    this.description = description;
    this.user_id = userId;
    this.post_id = postId;
  }
}
