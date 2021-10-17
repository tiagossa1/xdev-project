export default class CommentRequest {
  constructor(id, description, userId, postId) {
    this.id = id;
    this.description = description;
    this.user_id = userId;
    this.post_id = postId;
  }
}
