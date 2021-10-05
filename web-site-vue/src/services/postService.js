import axios from "axios";
import Post from "../models/post";
import PostType from "../models/postType";
import dayjs from "dayjs";

export default new (class PostService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async getPosts() {
    let response = await axios.get(`${this.apiUrl}/api/posts`);

    if (response.data.data) {
      return response.data.data.map((x) => {
        return new Post(
          x.id,
          x.title,
          x.description,
          x.suspended,
          x.user,
          x.post_type,
          x.post_photos,
          x.likes,
          x.tags,
          x.users_saved,
          x.comments,
          dayjs(dayjs(x.created_at)).fromNow()
        );
      });
    }

    return [];
  }

  async getPostTypes() {
    let response = await axios.get(`${this.apiUrl}/api/post-types`);

    if (response.data.data) {
      return response.data.data.map(
        (x) => new PostType(x.id, x.name, x.iconName)
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

  async deletePost(postId) {
    return await axios.delete(`${this.apiUrl}/api/posts/${postId}`);
  }
})();
