import District from "./district";
import UserType from "./userType";
import SchoolClass from "./schoolClass";
import Post from "./post";
import Tag from "./tag";

export default class User {
  constructor(
    id,
    email,
    name,
    birth_date,
    github_url = null,
    linkedin_url = null,
    facebook_url = null,
    instagram_url = null,
    profile_picture,
    district,
    userType,
    schoolClass,
    posts,
    tags,
    created_at
  ) {
    this.id = id;
    this.email = email;
    this.name = name;
    this.birth_date = birth_date;
    this.github_url = github_url;
    this.linkedin_url = linkedin_url;
    this.facebook_url = facebook_url;
    this.instagram_url = instagram_url;
    this.profile_picture = profile_picture;

    if (district) this.district = new District(district.id, district.name);

    if (userType)
      this.userType = new UserType(
        userType.id,
        userType.name,
        userType.hexColorCode
      );

    if (schoolClass)
      this.schoolClass = new SchoolClass(
        schoolClass.id,
        schoolClass.name,
        schoolClass.school
      );

    if (posts) {
      this.posts = posts.map(
        (x) =>
          new Post(
            x.id,
            x.title,
            x.description,
            x.suspended,
            x.user,
            x.post_type,
            x.post_photos,
            x.user_likes,
            x.tags,
            x.users_saved,
            x.comments,
            x.created_at
          )
      );
    }

    if (tags) {
      this.tags = tags.map((t) => new Tag(t.id, t.name, t.created_at));
    }

    this.created_at = created_at;
  }
}
