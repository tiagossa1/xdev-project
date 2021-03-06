import User from "./user";
import Post from "./post";
import ReportConclusion from "./reportConclusion";
import Comment from "./comment";

import dayjs from "dayjs";

export default class Report {
  constructor(report) {
    this.id = report?.id;
    this.user = report?.user ? new User(report?.user) : null;
    this.post = report?.post ? new Post(report?.post) : null;
    this.moderator = report?.moderator ? new User(report?.moderator) : null;
    this.reportConclusion = report?.reportConclusion ? new ReportConclusion(report?.reportConclusion) : null;
    this.postComment = report?.comment ? new Comment(report?.comment) : null;
    this.closed = Boolean(report?.closed);
    this.reason = report?.reason;

    this.createdAt = dayjs(report?.created_at).format('YYYY-MM-DD HH:mm:ss');
  }
}
