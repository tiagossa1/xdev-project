import axios from "axios";
import Tag from "../models/tag";

export default new (class TagService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async getTags() {
    let res = await axios.get(`${this.apiUrl}/api/tags`);

    if (res.data) {
      return res.data.data.map((t) => new Tag(t));
    }

    return [];
  }

  async getTagsByCount(count) {
    let res = await axios.get(`${this.apiUrl}/api/tags?count=${count}`);

    if (res.data) {
      return res.data.data.map((t) => new Tag(t));
    }

    return [];
  }
})();
