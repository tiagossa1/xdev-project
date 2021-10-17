import axios from "axios";

import Notification from "../models/notification";

export default new (class NotificationService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async getNotifications() {
    let res = await axios.get(`${this.apiUrl}/api/notifications`);
    return res.data.data.map((n) => new Notification(n));
  }

  async markAsRead(notificationId) {
    return await axios.post(`${this.apiUrl}/api/mark-notification`, {
      id: notificationId,
    });
  }
})();
