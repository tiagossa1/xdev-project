export default class Feedback {
  constructor(id, description, user, feedbackType, createdAt) {
    this.id = id;
    this.description = description;
    this.user = user;
    this.feedbackType = feedbackType;
    this.createdAt = createdAt;
  }
}
