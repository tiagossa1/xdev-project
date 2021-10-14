import Post from '../models/post';

export default class Notification {
  constructor(notification) {
    this.id = notification?.id;
    this.userId = notification?.data[0]?.user.id;
    this.userName = notification?.data[0]?.user?.name;
    this.userEmail = notification?.data[0]?.user?.email;
    this.reason = notification?.data[0]?.reason;
    this.post = new Post(notification?.data[0].post);
    // this.postId = notification?.data[0]?.post.id;
    this.postTitle = notification?.data[0]?.post.title;
    // this.reports = notification?.data?.map((r) => new Report(r));
  }
}
