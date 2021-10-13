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

  async getPostsByUser(userId) {
    let response = await axios.get(`${this.apiUrl}/api/posts?user_id=${userId}`);

    if (response.data.data) {
      return response.data.data.map((x) => {
        return new Post(x);
      });
    }

    return [];
  }

  async getPostTypes() {
    let response = await axios.get(`${this.apiUrl}/api/post-types`);

    if (response.data.data) {
      return response.data.data.map(
        (x) => new PostType(x)
      );
    }

    return [];
  }

  async insertPost(form) {
    return await axios.post(`${this.apiUrl}/api/posts`, form);
  }

  async changeLikePost(postId, userLikes) {
    return await axios.put(`${this.apiUrl}/api/posts/${postId}`, {
      likes: userLikes,
    });
  }

  async changeSavedPost(postId, postSaved) {
    return await axios.put(`${this.apiUrl}/api/posts/${postId}`, {
      users_saved: postSaved,
    });
  }

  async updatePost(post) {
    return await axios.put(`${this.apiUrl}/api/posts/${post.id}`, post);
  }

  async deletePost(postId) {
    return await axios.delete(`${this.apiUrl}/api/posts/${postId}`);
  }
})();
