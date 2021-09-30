export default class Post {
  constructor(id, title, description, suspended, user, postType, createdAt) {
    (this.id = id), (this.title = title);
    this.description = description;
    this.suspended = suspended;
    this.user = user;
    this.postType = postType;
    this.createdAt = createdAt;
  }
}
