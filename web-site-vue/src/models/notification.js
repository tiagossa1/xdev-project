import Report from '../models/report';

export default class Notification {
  constructor(notification) {
    this.id = notification?.id;
    this.report = new Report(notification?.data[0]);
  }
}
