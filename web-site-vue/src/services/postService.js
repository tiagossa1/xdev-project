import axios from "axios";
import Post from "../models/post";
import PostType from "../models/postType";

export default new (class PostService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async getPosts() {
    let response = await axios.get(`${this.apiUrl}/api/posts`);

    if (response.data.data) {
      return response.data.data.map((x) => {
        return new Post(x);
      });
    }

    return [];
  }

  async getPostById(id) {
    let res = await axios.get(`${this.apiUrl}/api/posts/${id}`);

    if (res.data.data) {
      return new Post(res.data.data);
    }

    return null;
  }

  async getPostsByUser(userId) {
    let response = await axios.get(
      `${this.apiUrl}/api/posts?user_id=${userId}`
    );

    if (response.data.data) {
      return response.data.data.map((x) => {
        return new Post(x);
      });
    }

    return [];
  }

  async getPostsByTagIds(tags) {
    let res = await axios.post(`${this.apiUrl}/api/posts/get-by-tags`, {
      tags: tags,
    });

    if (res.data.data) {
      return res.data.data.map((p) => {
        return new Post(p);
      });
    }

    return [];
  }

  async getPostTypes() {
    let response = await axios.get(`${this.apiUrl}/api/post-types`);

    if (response.data.data) {
      return response.data.data.map((x) => new PostType(x));
    }

    return [];
  }

  async create(form) {
    return await axios.post(`${this.apiUrl}/api/posts`, form);
  }

  async update(post) {
    return await axios.put(`${this.apiUrl}/api/posts/${post.id}`, post);
  }

  async delete(postId) {
    return await axios.delete(`${this.apiUrl}/api/posts/${postId}`);
  }
})();
