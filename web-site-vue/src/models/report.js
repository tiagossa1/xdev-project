import User from "./user";
import Post from "./post";
import ReportConclusion from "./reportConclusion";
import Comment from "./comment";

export default class Report {
  constructor(report) {
    this.id = report?.id;
    this.user = new User(report?.user);
    this.post = new Post(report?.post);
    this.moderator = new User(report?.moderator);
    this.reportConclusion = new ReportConclusion(report?.reportConclusion);
    this.postComment = new Comment(report?.postComment);
    this.closed = report?.closed;
    this.reason = report?.reason;
    this.createdAt = report?.created_at;
  }
}
