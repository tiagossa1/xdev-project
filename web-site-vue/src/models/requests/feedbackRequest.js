export default class FeedbackRequest {
  constructor(description, userId, feedbackTypeId) {
    this.description = description;
    this.user_id = userId;
    this.feedback_type_id = feedbackTypeId;
  }
}
