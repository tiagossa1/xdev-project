export default class Report {
  constructor(
    id,
    user,
    post,
    moderator,
    reportConclusion,
    postComment,
    closed,
    reason,
    createdAt
  ) {
    this.id = id;
    this.user = user;
    this.post = post;
    this.moderator = moderator;
    this.reportConclusion = reportConclusion;
    this.postComment = postComment;
    this.closed = closed;
    this.reason = reason;
    this.createdAt = createdAt;
  }
}
