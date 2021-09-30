export default class PostRequest {
  constructor(title, description, suspended, userId, postTypeId, createdAt) {
    (this.title = title);
    this.description = description;
    this.suspended = suspended;
    this.userId = userId;
    this.postTypeId = postTypeId;
    this.createdAt = createdAt;
  }
}
