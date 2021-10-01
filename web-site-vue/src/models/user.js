export default class User {
  constructor(
    id,
    email,
    name,
    birth_date,
    github_url,
    linkedin_url,
    facebook_url,
    instagram_url,
    district,
    userType,
    schoolClass,
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
    this.district = district;
    this.userType = userType;
    this.schoolClass = schoolClass;
    this.created_at = created_at;
  }
}