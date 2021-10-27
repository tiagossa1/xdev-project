export default class Tag {
  constructor(tag) {
    this.id = tag?.id;
    this.name = tag?.name;
    //nr de vezes em que a tag está num post
    this.postsCount = tag?.posts_count;
    this.createdAt = tag?.created_at;
  }
}
