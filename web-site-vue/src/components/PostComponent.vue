<template>
  <div class="container">
    <div class="buttons m-3">
      <b-button pill variant="info" v-b-modal.modal-1>Criar +</b-button>
      <b-modal id="modal-1" title="Criar Post">
        <b-form>
          <b-form-group label="Insira o titulo:" label-for="textTitle">
            <b-form-input
              id="textTitle"
              type="email"
              placeholder="Enter email"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group label="Insira a descrição:" label-for="textarea">
            <!--Substituir pelo richText-->
            <b-form-textarea
              id="textarea"
              placeholder="Enter something..."
              rows="3"
              max-rows="6"
            ></b-form-textarea>
          </b-form-group>

          <b-form-group label="Insira o tipo de post:" label-for="postType">
            <b-form-select
              id="postType"
              v-model="form.post_type"
              :options="postTypes"
              required
            ></b-form-select>
          </b-form-group>
        </b-form>
      </b-modal>

      <b-dropdown class="ml-2" id="dropdown-1" text="Filtro">
        <b-dropdown-item>First Action</b-dropdown-item>
      </b-dropdown>
    </div>
    <!--<div v-for="post in posts" class="post-container" v-bind:key="post.id">
            <span v-for="tag of tags" class="tags" v-bind:key="tag.name">
                {{tag.name}}
            </span>
            <br>
            <img width="70rem" src="https://cdn-icons-png.flaticon.com/512/147/147144.png" alt="{{}}">
        </div>-->
    <p>s</p>
  </div>
</template>

<script>
import postService from "../services/postService";

export default {
  name: "post-component",
  async mounted() {
    postService
      .getPostTypes()
      .then(
        (res) =>
          (this.postTypes = res.data.data.map((x) => ({
            value: x.id,
            text: x.name,
          })))
      )
      .catch((err) => console.log(err));

    // postService
    //   .getPosts(config)
    //   .then((res) => {
    //     console.log(res.data.data);
    //     this.posts = res.data.data;
    //   })
    //   .catch((err) => console.log(err));

    /*res.forEach((postApi) => {
                const {
                    id,
                    title,
                    description,
                    suspended,
                    user_id,
                    post_type_id,
                    created_at: {post_date},
                } = postApi;

                const post = new Post(
                    id,
                    title,
                    description,
                    suspended,
                    user_id,
                    post_type_id,
                    post_date
                );
                this.posts.push(post);
            });*/
    //console.log(res);
  },
  data() {
    return {
      posts: [],
      form: {
        post_type: null,
      },
      postTypes: [
        { text: "Escolha o tipo de post", value: null },
        "Oferta de emprego",
        "Batarde",
      ],
      /*posts:{
                tags:[
                    {name : 'C#'},
                    {name : 'TS'},
                    {name : 'JS'},
                    {name : 'boostrap'},
                ],
                userInfo:[
                    {name: 'Toni',school_class_id: 'TPSIP',school_id:'ATEC Matosinhos'},
                ],
            },*/
    };
  },
};
</script>

<style></style>
