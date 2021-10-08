import User from "./user";

export default class Feedback {
  constructor(feedback) {
    this.id = feedback?.id;
    this.description = feedback?.description;
    this.user = new User(feedback?.user);
    this.feedbackType = feedback?.feedback_type;
    this.createdAt = feedback?.created_at;
  }
}
