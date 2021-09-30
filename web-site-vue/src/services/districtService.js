import axios from "axios";
import District from "../models/district";

export default new (class DistrictService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async getDistricts() {
    let response = await axios.get(`${this.apiUrl}/api/districts`);

    if (response.data.data) {
      return response.data.data.map((x) => new District(x.id, x.name));
    }

    return [];
  }
})();
