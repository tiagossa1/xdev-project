import axios from "axios";
import User from "../models/user";

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

  async logout() {
    return await axios.post(`${this.apiUrl}/api/logout`);
  }

  async getUserById(id) {
    let response = await axios.get(`${this.apiUrl}/api/users/${id}`);

    if (response.data) {
      return new User(response.data);
    }

    return new User(null);
  }

  async updateLikedPosts(userId, likedPosts) {
    return await axios.put(`${this.apiUrl}/api/user/${userId}`, {
      liked_posts: likedPosts,
    });
  }

  async updateUserSocialMedia(userId, socialLink) {
    return await axios.post(`${this.apiUrl}/api/user/${userId}`, {
      github_url : socialLink.github_url,
      facebook_url : socialLink.facebook_url,
      instagram_url : socialLink.instagram_url,
      linkedin_url : socialLink.linkedin_url,
    });
  }





})();
