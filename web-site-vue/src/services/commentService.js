import axios from "axios";

export default new (class CommentService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async create(commentRequest) {
    return await axios.post(`${this.apiUrl}/api/comments/`, commentRequest);
  }

  async edit(request) {
    return await axios.put(`${this.apiUrl}/api/comments/${request.id}`, request);
  }

  async delete(id) {
    return await axios.delete(`${this.apiUrl}/api/comments/${id}`);
  }
})();
