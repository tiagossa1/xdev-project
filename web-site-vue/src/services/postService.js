import axios from "axios";
import Post from "../models/post";
import PostType from "../models/postType";
import dayjs from 'dayjs'

export default new (class PostService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async getPosts() {
    let response = await axios.get(`${this.apiUrl}/api/posts`);
    response.data.data.forEach(x => {
      console.log(x)
    });
    if (response.data.data) {
      return response.data.data.map(
        (x) =>
          new Post(
            x.id,
            x.title,
            x.description,
            x.suspended,
            x.user,
            x.postType,
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
      return response.data.data.map((x) => new PostType(x.id, x.name, x.iconName));
    }

    return [];
  }

  async insertPost(form){
    return await axios.post(`${this.apiUrl}/api/posts`,form);
  }

  /*async insertPostTags(form){
    return await axios.post(`${this.apiUrl}/api/post-tags`,form);
  }*/

})();
