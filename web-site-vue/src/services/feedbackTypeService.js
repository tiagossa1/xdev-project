import axios from "axios";
import FeedbackType from "../models/feedbackType";

export default new (class FeedbackTypeService {
    constructor() {
        this.apiUrl = process.env.VUE_APP_API_URL;
    }

    async getFeedbackTypes() {
        let response = await axios.get(`${this.apiUrl}/api/feedback-types`);
        if (response.data.data) {
            return response.data.data.map((f) => new FeedbackType(f));
        }

        return [];
    }
})();
