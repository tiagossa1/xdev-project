export default class ReportRequest {
  constructor(
    userId,
    postId,
    moderatorId,
    reportConclusion,
    postCommentId,
    closed,
    reason,
    createdAt
  ) {
    this.id = id;
    this.userId = userId;
    this.postId = postId;
    this.moderatorId = moderatorId;
    this.reportConclusion = reportConclusion;
    this.postCommentId = postCommentId;
    this.closed = closed;
    this.reason = reason;
    this.createdAt = createdAt;
  }
}
