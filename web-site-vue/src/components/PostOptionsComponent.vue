<template>
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
              v-model="form.post_type_id"
              :options="postTypes"
              :value="null"
              required
            ></b-form-select>
          </b-form-group>
        </b-form>
      </b-modal>

      <b-dropdown class="ml-2" id="dropdown-1" text="Filtro">
        <b-dropdown-item>First Action</b-dropdown-item>
      </b-dropdown>
    </div>
</template>

<script>
import postService from "../services/postService";
export default {
    name: "post-options-component",

    created(){
        /*const config = {
      headers: {
        Authorization: `Bearer 1|7X7BTKjq40o7vfRHPqaeDYalI2Qm3FHDLOm0Cd4n`,
      },
    };*/
    postService
      .getPostTypes(/*config*/)
      .then(
        (res) =>
          (this.postTypes = res.data.data.map((x) => ({
            value: x.id,
            text: x.name,
          })))
      )
      .catch((err) => console.log(err));
    },
    data(){
        return{
            postTypes: [],
            form: {
                post_type_id: null,
            },
        }
    }
}
</script>

<style>

</style>