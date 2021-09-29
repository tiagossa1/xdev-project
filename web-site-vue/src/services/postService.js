import axios from "axios";

export default new (class PostService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async getPosts() {
    return await axios.get(`${this.apiUrl}/api/posts`);
  }

  async getPostTypes() {
    return await axios.get(`${this.apiUrl}/api/post-types`);
  }
})();
