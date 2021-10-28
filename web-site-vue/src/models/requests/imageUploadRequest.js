export default class ImageUploadRequest {
  constructor(user_id, profile_picture) {
    this.email = user_id;
    this.profile_picture = profile_picture;
  }
}
