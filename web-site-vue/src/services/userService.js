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
      return new User(
        response.data.id,
        response.data.email,
        response.data.name,
        response.data.birth_date,
        response.data.github_url,
        response.data.linkedin_url,
        response.data.facebook_url,
        response.data.instagram_url,
        response.data?.profile_picture,
        response.data.district,
        response.data.user_type,
        response.data.school_class,
        response.data.created_at
      );
    }

    return {};
  }

  async updateLikedPosts(userId, likedPosts) {
    return await axios.put(`${this.apiUrl}/api/user/${userId}`, {
      liked_posts: likedPosts,
    });
  }
})();
