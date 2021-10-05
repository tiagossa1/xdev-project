import axios from "axios";

export default new (class CommentService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async createComment(commentRequest) {
    return await axios.post(`${this.apiUrl}/api/comments/`, commentRequest);
  }

  async deleteComment(id) {
    return await axios.delete(`${this.apiUrl}/api/comments/${id}`);
  }
})();
