<template>
  <b-container>
    <b-row class="buttons p-2">
      <b-col>
        <b-button pill variant="primary" v-b-modal.modal-1>Criar +</b-button>
        <b-dropdown class="ml-2" id="dropdown-1" text="Filtro">
          <b-dropdown-item>First Action</b-dropdown-item>
        </b-dropdown>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-modal id="modal-1" title="Criar Post" @ok="createPost">
          <b-form>
            <b-form-group label="Insira o titulo:" label-for="textTitle">
              <b-form-input
                id="textTitle"
                type="email"
                v-model="form.title"
                placeholder="Insira o titulo"
                required
              ></b-form-input>
            </b-form-group>

            <b-form-group label="Insira a descrição:" label-for="textarea">
              <!--Substituir pelo richText-->
              <b-form-textarea
                id="textarea"
                v-model="form.description"
                placeholder="Insira o assunto do post"
                rows="3"
                max-rows="6"
              ></b-form-textarea>
            </b-form-group>

            <b-form-group label="Insira o tipo de post:" label-for="postType">
              <b-form-select
                id="postType"
                v-model="form.post_type_id"
                :options="postTypes"
                :value="null"
                required
              ></b-form-select>
            </b-form-group>

            <b-form-group label="Insira as tags do post:" label-for="postTags">
              <b-form-tags
                id="postTags"
                v-model="postTags.tag_id"
                separator=" "
                required
              ></b-form-tags>

              <template #invalid-feedback>
                Tem de introduzir pelo menos 1 tag e no máximo 6.
              </template>

              <template #description>
                <div id="tags-validation-help">
                  Os posts têm de ter pelo menos 1 tag e no máximo 6.
                </div>
              </template>
            </b-form-group>
          </b-form>
        </b-modal>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import postService from "../services/postService";
export default {
  name: "post-options-component",

  created() {
    postService
      .getPostTypes()
      .then(
        (res) =>
          (this.postTypes = res.map((x) => ({
            value: x.id,
            text: x.name,
          })))
      )
      .catch((err) => console.log(err));
  },
  data() {
    return {
      postTypes: [],
      form: {
        title: "",
        description: "",
        post_type_id: "",
        // VERIFICAR QUAL O USER QUE FEZ O POST
        user_id: 1,
        suspended: 0,
      },
      postTags: [
        {
          //post_id : "",
          tag_id: "",
        },
      ],
    };
  },
  methods: {
    createPost() {
      postService.insertPost(this.form);
      console.log(this.form);
    },
  },
};
</script>
