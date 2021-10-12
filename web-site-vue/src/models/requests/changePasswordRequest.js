export default class ChangePasswordRequest {
    constructor(oldPassword, newPassword, confirmPassword) {
        this.old_password = oldPassword;
        this.new_password = newPassword;
        this.confirm_password = confirmPassword;
    }
}