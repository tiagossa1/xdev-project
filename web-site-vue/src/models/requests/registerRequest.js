export default class RegisterRequest {
  constructor(
    name,
    email,
    password,
    districtId,
    schoolClassId,
    birthDate,
    profilePicture
  ) {
    this.name = name;
    this.email = `${email}@edu.atec.pt`;
    this.password = password;
    this.district_id = districtId;
    this.school_class_id = schoolClassId;
    this.birth_date = birthDate;
    this.user_type_id = 1;
    this.profile_picture = profilePicture;
  }
}
