import axios from "axios";

export default new (class ImageUploaddService {
  constructor() {
    this.apiUrl = process.env.VUE_APP_API_URL;
  }

  async createImageUpload(imageUploadRequest) {
    let fd = new FormData();

    fd.append('email', imageUploadRequest.email);
    fd.append('profile_picture', imageUploadRequest.profile_picture);

    return await axios.post(`${this.apiUrl}/api/image-upload/`, imageUploadRequest);
  }
})();
