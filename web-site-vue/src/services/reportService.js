import axios from "axios";

import Report from "../models/report";

export default new (class ReportService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async getOpenReports() {
    let res = await axios.get(`${this.apiUrl}/api/open-reports`);

    if (res.data.data) {
      return res.data.data.map((r) => new Report(r));
    }

    return [];
  }

  async getById(id) {
    let res = await axios.get(`${this.apiUrl}/api/reports/${id}`);

    if (res.data.data) {
      return new Report(res.data.data);
    }

    return null;
  }

  async create(reportRequest) {
    return await axios.post(`${this.apiUrl}/api/reports`, reportRequest);
  }

  async update(request) {
    return await axios.put(`${this.apiUrl}/api/reports/${request.id}`, request);
  }
})();
