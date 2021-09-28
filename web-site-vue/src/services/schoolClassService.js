import axios from "axios";

export default new (class SchoolClassService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async getSchoolClasses(config) {
    return await axios.get(`${this.apiUrl}/api/school-classes`, config);
  }
})();
