import District from "./district";
import UserType from "./userType";
import SchoolClass from "./schoolClass";
import School from "./school";

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
        new School(schoolClass.school.id, schoolClass.school.name)
      );
    this.created_at = created_at;
  }
}
