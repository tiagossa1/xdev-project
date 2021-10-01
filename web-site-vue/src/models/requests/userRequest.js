export default class User {
  constructor(
    email,
    name,
    birth_date,
    github_url,
    linkedin_url,
    facebook_url,
    instagram_url,
    districtId,
    profile_picture,
    userTypeId,
    schoolClassId,
    created_at
  ) {
    this.email = email;
    this.name = name;
    this.birth_date = birth_date;
    this.github_url = github_url;
    this.linkedin_url = linkedin_url;
    this.facebook_url = facebook_url;
    this.profile_picture = profile_picture;
    this.instagram_url = instagram_url;
    this.districtId = districtId;
    this.userTypeId = userTypeId;
    this.schoolClassId = schoolClassId;
    this.created_at = created_at;
  }
}
