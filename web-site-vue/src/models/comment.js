import User from "./user";

export default class Comment {
  constructor(comment) {
    this.id = comment?.id;
    (this.user = new User(comment?.user)),
      (this.description = comment?.description);
    this.createdAt = comment?.created_at;
    this.updatedAt = comment?.updated_at;
  }
}
