export default class FeedbackRequest {
  constructor(description, userId, feedbackTypeId, createdAt) {
    this.description = description;
    this.userId = userId;
    this.feedbackTypeId = feedbackTypeId;
    this.createdAt = createdAt;
  }
}
