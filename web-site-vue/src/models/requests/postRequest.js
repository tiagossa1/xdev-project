export default class PostRequest {
  constructor(
    id,
    title,
    description,
    suspended,
    userId,
    postTypeId,
  ) {
    this.id = id;
    this.title = title;
    this.description = description;
    this.suspended = suspended;
    this.user_id = userId;
    this.post_type_id = postTypeId;
  }
}
