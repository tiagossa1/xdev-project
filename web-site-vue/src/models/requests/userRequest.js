export default class User {
  constructor(
    id,
    email,
    name,
    birth_date,
    profile_picture,
    github_url,
    linkedin_url,
    facebook_url,
    instagram_url,
    created_at,
    district,
    school_class,
    user_type,
    posts,
    tags,
    liked_posts,
    comments,
    
  ) {
    this.id = id;
    this.email = email;
    this.name = name;
    this.birth_date = birth_date;
    this.profile_picture = profile_picture;
    this.github_url = github_url;
    this.linkedin_url = linkedin_url;
    this.facebook_url = facebook_url;
    this.instagram_url = instagram_url;
    this.user_type = user_type;
    this.school_class = school_class;
    this.created_at = created_at;
    this.district = district;
    this.school_class = school_class;
    this.posts = posts;
    this.tags = tags;
    this.liked_posts = liked_posts;
    this.comments = comments;
  }
}
