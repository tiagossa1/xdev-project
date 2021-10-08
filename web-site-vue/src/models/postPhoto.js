export default class PostPhoto {
  constructor(postPhoto) {
    this.id = postPhoto?.id;
    this.url = postPhoto?.url;
    this.createdAt = postPhoto?.created_at;
  }
}
