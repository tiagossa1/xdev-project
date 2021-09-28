export default class Post {
    constructor(id,title,description,suspended,user_id,post_type_id,created_at=null){
        this.id = id,  
        this.title = title
        this.description = description
        this.suspended = suspended
        this.user_id = user_id
        this.post_type_id = post_type_id
        this.created_at = created_at
    }
}