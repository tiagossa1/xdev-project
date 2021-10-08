import Comment from "../models/comment";

import axios from "axios";

export default new (class CommentService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async createComment(commentRequest) {
    let res = await axios.post(`${this.apiUrl}/api/comments/`, commentRequest);

    if (res.data.data) {
      return new Comment(res.data.data);
    }

    return null;
  }

  async deleteComment(id) {
    return await axios.delete(`${this.apiUrl}/api/comments/${id}`);
  }
})();
