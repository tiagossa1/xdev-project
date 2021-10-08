export default class FeedbackType {
  constructor(feedbackType) {
    if (feedbackType) {
      this.id = feedbackType?.id;
      this.name = feedbackType?.name;
    }

    return {};
  }
}
