import axios from "axios";
import User from "../models/requests/userRequest";
import District from "../models/district";
import SchoolClass from "../models/schoolClass";
import School from "../models/school";
import Post from "../models/post";
import UserType from "../models/userType";

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
    console.log(response);
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
            new District(user.district.id, user.district.name),
            new SchoolClass(
              user.school_class.id,
              user.school_class.name,
              new School(
                user.school_class.school.id,
                user.school_class.school.name
              )
            ),
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
            new UserType(
              user.usertype.id,
              user.usertype.name,
              user.usertype.hexColorCode
            )
          )
      );
    }
  }
})();
