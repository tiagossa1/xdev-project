import User from "./user";
import PostType from "./postType";
import PostPhoto from "./postPhoto";
import Tag from "./tag";
import Comment from "./comment";

import dayjs from "dayjs";

export default class Post {
  constructor(post) {
    (this.id = post?.id), (this.title = post?.title);
    this.description = post?.description;
    this.suspended = post?.suspended;
    this.user = new User(post?.user);
    this.postType = new PostType(post?.post_type);
    this.postPhotos = post?.post_photos.map((pp) => new PostPhoto(pp));

    if (post?.likes?.length > 0) {
      this.userLikes = post?.likes.map((ul) => ul.id);
    } else {
      this.userLikes = [];
    }

    this.tags = post?.tags.map((t) => new Tag(t));

    if (post?.users_saved?.length > 0) {
      this.usersSaved = post?.users_saved.map((x) => x.id);
    } else {
      this.usersSaved = [];
    }

    if (post.comments?.length > 0) {
      this.comments = post.comments.map((c) => {
        return new Comment(c);
      });
    } else {
      this.comments = [];
    }

    this.createdAt = dayjs(dayjs(post.created_at)).fromNow();
  }
}
