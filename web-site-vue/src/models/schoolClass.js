import School from "./school";

export default class SchoolClass {
    constructor(id, name, school) {
        this.id = id;
        this.name = name;
        this.school = new School(school.id, school.name)
    }
}