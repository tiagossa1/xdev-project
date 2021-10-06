import User from "./user";
import PostType from "./postType";
import PostPhoto from "./postPhoto";
import Tag from "./tag";
import Comment from "./comment";

export default class Post {
  constructor(
    id,
    title,
    description,
    suspended,
    user,
    postType,
    postPhotos,
    userLikes,
    tags,
    usersSaved,
    comments,
    createdAt
  ) {
    (this.id = id), (this.title = title);
    this.description = description;
    this.suspended = suspended;

    if (user) {
      this.user = new User(
        user.id,
        user.email,
        user.name,
        user.birth_date,
        user.github_url,
        user.linkedin_url,
        user.facebook_url,
        user.instagram_url,
        user.profile_picture ?? "",
        user.district,
        user.user_type,
        user.school_class,
        user.created_at
      );
    }

    if (postType) {
      this.postType = new PostType(
        postType.id,
        postType.name,
        postType.iconName
      );
    }

    if (postPhotos) {
      this.postPhotos = postPhotos.map(
        (pp) => new PostPhoto(pp.id, pp.url, pp.created_at)
      );
    }

    if (userLikes) {
      this.userLikes = userLikes.map((ul) => ul.id);
    }

    if (tags) {
      this.tags = tags.map((t) => new Tag(t.id, t.name, t.created_at));
    }

    if (usersSaved) {
      this.usersSaved = usersSaved.map((x) => x.id);
    }

    if (comments && comments.length > 0) {
      this.comments = comments.map((x) => {
        return new Comment(
          x.id,
          x.description,
          x.user,
          x.created_at,
          x.updated_at
        );
      });
    }
    this.createdAt = createdAt;
  }
}
