import axios from "axios";
import User from "../models/requests/userRequest";
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

  async logout() {
    return await axios.post(`${this.apiUrl}/api/logout`);
  }

  async getUserById(id) {
    let response = await axios.get(`${this.apiUrl}/api/users/${id}`);

    if (response.data) {
      return response.data.map(
        (user) =>
          new User(
            user.id,
            user.email,
            user.name,
            user.birth_date,
            user.profile_picture,
            user.github_url,
            user.linkedin_url,
            user.facebook_url,
            user.instagram_url,
            user.created_at,
            user.district,
            user.user_type,
            user.posts.map(
              (p) =>
                new Post(
                  p.id,
                  p.title,
                  p.description,
                  p.suspended,
                  null,
                  p.post_type,
                  p.post_photos,
                  p.tags,
                  p.createdAt
                )
            ),
            user.user_type
          )
      );
    }

    return new User();
  }

  async updateLikedPosts(userId, likedPosts) {
    return await axios.put(`${this.apiUrl}/api/user/${userId}`, {
      liked_posts: likedPosts
    })
  }
})();
