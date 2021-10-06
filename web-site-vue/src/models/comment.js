import User from "./user";

export default class Comment {
  constructor(id, description, user, createdAt, updatedAt) {
    this.id = id;
    (this.user = new User(
      user.id,
      user.email,
      user.name,
      user.birth_date,
      user.github_url,
      user.linkedin_url,
      user.facebook_url,
      user.instagram_url,
      null,
      user?.district,
      user?.user_type,
      user?.school_class,
      user?.posts,
      user?.tags,
      user.created_at
    )),
      (this.description = description);
    this.createdAt = createdAt;
    this.updatedAt = updatedAt;
  }
}
