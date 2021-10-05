import axios from "axios";

export default new (class ReportService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async createReport(reportRequest) {
    return await axios.post(`${this.apiUrl}/api/reports`, reportRequest);
  }
})();
