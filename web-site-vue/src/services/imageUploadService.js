import axios from "axios";

export default new (class ImageUploaddService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async createImageUpload(config, imageUploadRequest) {
    let fd = new FormData();

    fd.append('user_id', imageUploadRequest.user_id);
    fd.append('profile_picture', imageUploadRequest.profile_picture);

    return await axios.post(`${this.apiUrl}/api/image-upload/`, imageUploadRequest, config);
  }
})();
