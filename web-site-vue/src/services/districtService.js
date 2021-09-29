import axios from "axios";

export default new (class DistrictService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async getDistricts() {
    return await axios.get(`${this.apiUrl}/api/districts`);
  }
})();
