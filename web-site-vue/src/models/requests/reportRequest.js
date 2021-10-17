export default class ReportRequest {
  constructor(
    id,
    userId,
    postId,
    moderatorId,
    reportConclusion,
    commentId,
    closed,
    reason,
    createdAt
  ) {
    this.id = id;
    this.user_id = userId;
    this.post_id = postId;
    this.moderator_id = moderatorId;
    this.report_conclusion = reportConclusion;
    this.comment_id = commentId;
    this.closed = closed;
    this.reason = reason;
    this.created_at = createdAt;
  }
}
