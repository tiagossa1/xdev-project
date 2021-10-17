import axios from "axios";
import Feedback from "../models/feedback";

export default new (class FeedbackService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async getFeedbacks() {
    let response = await axios.get(`${this.apiUrl}/api/feedbacks`);
    if (response.data.data) {
      return response.data.data.map((f) => new Feedback(f));
    }

    return [];
  }

  async update(post) {
    return await axios.put(`${this.apiUrl}/api/feedbacks/${post.id}`, post);
  }

  async delete(id) {
    return await axios.delete(`${this.apiUrl}/api/feedbacks/${id}`);
  }
})();
