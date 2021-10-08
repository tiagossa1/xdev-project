import School from "./school";

export default class SchoolClass {
  constructor(schoolClass) {
    this.id = schoolClass?.id;
    this.name = schoolClass?.name;
    this.school = new School(schoolClass?.school);
  }
}
