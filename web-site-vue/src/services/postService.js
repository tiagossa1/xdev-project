import axios from "axios";

export default new (class PostService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async getPosts(config) {
    return await axios.get(`${this.apiUrl}/api/posts`, config);
  }

  async getPostTypes(config) {
    return await axios.get(`${this.apiUrl}/api/post-types`, config);
  }
})();
