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
    this.user_id = userId;
    this.post_id = postId;
    this.moderator_id = moderatorId;
    this.report_conclusion = reportConclusion;
    this.post_comment_id = postCommentId;
    this.closed = closed;
    this.reason = reason;
    this.created_at = createdAt;
  }
}
