import axios from "axios";
import SchoolClass from "../models/schoolClass";

export default new (class SchoolClassService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async getSchoolClasses() {
    let response = await axios.get(`${this.apiUrl}/api/school-classes`);

    if (response.data.data) {
      return response.data.data.map((x) => new SchoolClass(x.id, x.name, x.school));
    }

    return [];
  }
})();
