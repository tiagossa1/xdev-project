import axios from "axios";
import ReportConclusion from "../models/reportConclusion";

export default new (class ReportConclusionService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async get() {
    let res = await axios.get(`${this.apiUrl}/api/report-conclusions`);

    if (res.data.data) {
      return res.data.data.map((rc) => new ReportConclusion(rc));
    }

    return [];
  }

  async getByName(name) {
    let res = await axios.get(
      `${this.apiUrl}/api/report-conclusions?name=${name}`
    );

    if (res.data.data) {
      return res.data.data.map((rc) => new ReportConclusion(rc));
    }

    return [];
  }
})();
