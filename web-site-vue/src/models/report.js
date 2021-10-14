import User from "./user";
import Post from "./post";
import ReportConclusion from "./reportConclusion";
import Comment from "./comment";

export default class Report {
  constructor(report) {
    this.id = report?.id;
    this.user = report?.user ? new User(report?.user) : null;
    this.post = report?.post ? new Post(report?.post) : null;
    this.moderator = report?.moderator ? new User(report?.moderator) : null;
    this.reportConclusion = report?.reportConclusion ? new ReportConclusion(report?.reportConclusion) : null;
    this.postComment = report?.postComment ? new Comment(report?.postComment) : null;
    this.closed = Boolean(report?.closed);
    this.reason = report?.reason;
    this.createdAt = report?.created_at;
  }
}
