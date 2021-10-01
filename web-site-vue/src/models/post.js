export default class Post {
  constructor(id, title, description, suspended, user, postType, postPhotos, tags, createdAt) {
    (this.id = id), (this.title = title);
    this.description = description;
    this.suspended = suspended;
    this.user = user;
    this.postType = postType;
    this.postPhotos = postPhotos;
    this.tags = tags;
    this.createdAt = createdAt;
  }
}
