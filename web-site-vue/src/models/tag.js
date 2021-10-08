export default class Tag {
  constructor(tag) {
    this.id = tag?.id;
    this.name = tag?.name;
    this.createdAt = tag?.created_at;
  }
}
