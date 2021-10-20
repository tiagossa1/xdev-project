import Report from "../models/report";
import Post from '../models/post';

export default class Notification {
  constructor(notification) {
    let type = notification?.type.split("\\");

    this.id = notification?.id;
    this.type = type[type.length - 1];

    if (this.type.toLowerCase() === "newreport") {
      this.report = new Report(notification?.data[0]);
    } else if (this.type.toLowerCase() === "newpost") {
      this.post = new Post(notification?.data[0]);
    }
  }
}
