import axios from "axios";
import User from "../models/user";
import UserType from "../models/userType";
import Comment from "../models/comment";

import postService from "./postService";
import Post from "../models/post";

export default new (class UserService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async login(form) {
    return await axios.post(`${this.apiUrl}/api/login`, form);
  }

  async register(form) {
    return await axios.post(`${this.apiUrl}/api/register`, form);
  }

  async resend(email) {
    return await axios.get(`${this.apiUrl}/api/email/resend?email=${email}`);
  }

  async isUserVerified(email) {
    return await axios.get(
      `${this.apiUrl}/api/email/is-verified?email=${email}`
    );
  }

  async isModerator() {
    let res = await axios.get(`${this.apiUrl}/api/is-moderator`);
    return Boolean(res.data.isModerator);
  }

  async isSheriff() {
    let res = await axios.get(`${this.apiUrl}/api/is-sheriff`);
    return Boolean(res.data.isxSheriff);
  }

  async logout() {
    return await axios.post(`${this.apiUrl}/api/logout`);
  }

  async changePassword(changePasswordRequest) {
    return await axios.post(
      `${this.apiUrl}/api/change-password`,
      changePasswordRequest
    );
  }

  async getUsers() {
    let res = await axios.get(`${this.apiUrl}/api/users`);

    if (res.data) {
      return res.data.data.map((u) => new User(u));
    }

    return [];
  }

  async getUserByToken() {
    return await axios.get(`${this.apiUrl}/api/get-user`);
  }

  async getUserById(id) {
    let response = await axios.get(`${this.apiUrl}/api/users/${id}`);

    if (response.data.data) {
      return new User(response.data.data);
    }

    return new User(null);
  }

  async getUserTypes() {
    const res = await axios.get(`${this.apiUrl}/api/user-types`);

    if (res.data) {
      return res.data.data.map((ut) => new UserType(ut));
    }

    return [];
  }

  async updateLikedPosts(userId, likedPosts) {
    return await axios.put(`${this.apiUrl}/api/user/${userId}`, {
      liked_posts: likedPosts,
    });
  }

  async update(user) {
    return await axios.put(`${this.apiUrl}/api/users/${user.id}`, user);
  }

  async delete(id) {
    return await axios.delete(`${this.apiUrl}/api/users/${id}`);
  }

  async getRecentFeed(id) {
    const res = await axios.get(`${this.apiUrl}/api/recent-activity/${id}`);

    if (res.data) {
      let posts = [];

      if (res.data.post_likes) {
        res.data.post_likes.forEach(async postLike => {
          let post = await postService.getPostById(postLike.post_id);
          posts.push(post);
        });
      }

      return { comments: res.data.comments.map(c => new Comment(c)), likes: posts };
    }
  }

  async getFavoritePosts(id) {
    const res = await axios.get(`${this.apiUrl}/api/users/favorite-posts/${id}`);
    // console.log(res.data.posts)
    return res.data.posts.map((x) => {
      return new Post(x);
    });
  }

})();
