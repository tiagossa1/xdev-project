import axios from "axios";

export default new (class ReportService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async createReport(reportRequest) {
    return await axios.post(`${this.apiUrl}/api/reports`, reportRequest);
  }

  async update(request) {
    return await axios.put(`${this.apiUrl}/api/reports/${request.id}`, request);
  }
})();
