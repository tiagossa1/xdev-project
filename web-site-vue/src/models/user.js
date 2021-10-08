import District from "./district";
import UserType from "./userType";
import SchoolClass from "./schoolClass";
import Post from "./post";
import Tag from "./tag";

export default class User {
  constructor(user) {
    this.id = user?.id;
    this.email = user?.email;
    this.name = user?.name;
    this.birth_date = user?.birth_date;
    this.github_url = user?.github_url;
    this.linkedin_url = user?.linkedin_url;
    this.facebook_url = user?.facebook_url;
    this.instagram_url = user?.instagram_url;
    this.profile_picture = user?.profile_picture;
    this.district = new District(user?.district?.id, user?.district?.name);
    this.userType = new UserType(user?.user_type);
    this.schoolClass = new SchoolClass(user?.school_class);

    if (user?.posts?.length > 0) {
      this.posts = user.posts.map((x) => new Post(x));
    } else {
      this.posts = [];
    }

    if (user?.tags?.length > 0) {
      this.tags = user.tags.map((t) => new Tag(t));
    } else {
      this.tags = [];
    }

    this.createdAt = user?.created_at;
  }
}
