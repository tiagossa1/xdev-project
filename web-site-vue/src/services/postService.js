import axios from "axios";
import Post from "../models/post";
import PostType from "../models/postType";
import PostPhoto from "../models/postPhoto";
import Tag from '../models/tag';
import dayjs from "dayjs";

export default new (class PostService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async getPosts() {
    let response = await axios.get(`${this.apiUrl}/api/posts`);
    if (response.data.data) {
      return response.data.data.map(
        (x) =>
          new Post(
            x.id,
            x.title,
            x.description,
            x.suspended,
            x.user,
            new PostType(
              x.post_type.id,
              x.post_type.name,
              x.post_type.iconName
            ),
            x.post_photos.map(
              (pp) => new PostPhoto(pp.id, pp.url, pp.created_at)
            ),
            x.tags.map(t => new Tag(t.id, t.name, t.created_at)),
            dayjs(dayjs(x.created_at)).fromNow()
            //dayjs(x.createdAt).fromNow()
          )
      );
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

  async likePost(id) {
    return await axios.put(`${this.apiUrl}/api/posts/${id}`, {});
  }
})();
