<template>
  <div>
    <p class="h5 font-weight-bold mb-3">
      Gestão de Tags
      <b-icon
        v-b-modal.create-tag-modal
        class="cursor-pointer align-middle"
        icon="plus"
        font-scale="1.2"
      ></b-icon>
    </p>
    <b-table
      ref="tagsTable"
      sticky-header="500px"
      table-variant="light"
      striped
      bordered
      borderless
      outlined
      :fields="fields"
      :items="tags"
    >
      <template #cell(name)="data">
        <b-badge class="p-1" variant="secondary"> {{ data.value }} </b-badge>
      </template>
      <template #cell(actions)="data">
        <b-button class="m-1" @click="onEditTag(data.item)" variant="warning"
          >Editar</b-button
        >
        <b-button
          class="m-1"
          @click="onDeleteTag(data.item.id)"
          variant="danger"
        >
          Eliminar
        </b-button>
      </template>
    </b-table>

    <b-modal @ok="onClick" ok-only id="create-tag-modal" title="Criar Tag">
      <b-form-group id="name-group" label="Nome" label-for="name">
        <b-form-input
          id="name"
          v-model="form.name"
          type="text"
          placeholder="Escreva um nome para a tag..."
          :state="!v$.form.name.$invalid"
          @blur="v$.form.name.$touch"
        ></b-form-input>
      </b-form-group>
    </b-modal>

    <b-modal @ok="onEditedTag" ref="edit-tag-modal" ok-only title="Editar Tag">
      <b-form-group id="name-group" label="Nome" label-for="name">
        <b-form-input
          id="name"
          v-model="tagSelected.name"
          type="text"
          placeholder="Escreva um nome para a tag..."
        ></b-form-input>
      </b-form-group>
    </b-modal>
  </div>
</template>

<script>
import Tag from "../../models/tag";
import TagRequest from "../../models/requests/tagRequest";

import tagService from "../../services/tagService";

import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default {
  name: "tags-management-component",
  data() {
    return {
      form: {
        name: "",
      },
      tagSelected: {},
      tags: [],
      fields: [
        { key: "name", label: "Tag" },
        { key: "createdAt", label: "Criada a" },
        { key: "actions", label: "Ações" },
      ],
    };
  },
  setup: () => ({ v$: useVuelidate() }),
  validations() {
    return {
      form: {
        name: { required },
      },
    };
  },
  async mounted() {
    let tags = await tagService.getTags();
    this.tags = tags.sort((a, b) =>
      a.name.toLowerCase() > b.name.toLowerCase() ? 1 : -1
    );
  },
  methods: {
    async onEditTag(tag) {
      this.tagSelected = tag;
      this.$refs["edit-tag-modal"].show();
    },
    async onEditedTag() {
      let req = new TagRequest(this.tagSelected.name, null);
      let res = await tagService
        .update(this.tagSelected.id, req)
        .catch(async (err) => {
          let originalTag = await tagService.getTagById(this.tagSelected.id);

          const index = this.tags.findIndex(
            (t) => t.id === this.tagSelected.id
          );

          if (index > -1) {
            this.tags[index] = originalTag;
          }

          this.$refs.tagsTable.refresh();

          let error;

          if (err.response.data.errors) {
            error = Object.values(err.response.data.errors)
              .map((v) => v.join(", "))
              .join(", ");
          }

          this.$swal({
            icon: "error",
            position: "bottom-right",
            title: error ?? err.response.data.message,
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 10000,
          });
        });

      if (res.status === 200) {
        let tagEdited = new Tag(res.data.data);
        let index = this.tags.findIndex((t) => t.id === this.tagSelected.id);

        if (index > -1) {
          this.tags[index] = tagEdited;
          this.tags = this.tags.sort((a, b) =>
            a.name.toLowerCase() > b.name.toLowerCase() ? 1 : -1
          );
        }

        // this.$root.$emit("reload-tags", this.tags);

        this.$swal({
          icon: "success",
          position: "bottom-right",
          title: "Tag editada!",
          toast: true,
          showCloseButton: true,
          showConfirmButton: false,
          timer: 10000,
        });
      }
    },
    async onDeleteTag(id) {
      this.$swal({
        title: "Confirmação",
        text: "Deseja mesmo apagar a tag?",
        showCancelButton: true,
        confirmButtonText: "Apagar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#dc3545",
      }).then(async (result) => {
        if (result.isConfirmed) {
          const res = await tagService.delete(id).catch((err) => {
            let error;

            if (err.response.data.errors) {
              error = Object.values(err.response.data.errors)
                .map((v) => v.join(", "))
                .join(", ");
            }

            this.$swal({
              icon: "error",
              position: "bottom-right",
              title: error ?? err.response.data.message,
              toast: true,
              showCloseButton: true,
              showConfirmButton: false,
              timer: 10000,
            });
          });

          if (res.status === 200) {
            const index = this.tags.findIndex((t) => t.id === id);

            if (index > -1) {
              this.tags.splice(index, 1);
            }

            // this.$root.$emit("reload-tags", this.tags);
          }

          this.$swal({
            icon: "success",
            position: "bottom-right",
            title: "Tag eliminada!",
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 10000,
          });
        }
      });
    },
    async onClick(bvModalEvt) {
      if (!this.v$.$invalid) {
        let req = new TagRequest(this.form.name, null);
        let res = await tagService.create(req).catch((err) => {
          let error;

          if (err.response.data.errors) {
            error = Object.values(err.response.data.errors)
              .map((v) => v.join(", "))
              .join(", ");
          }

          this.$swal({
            icon: "error",
            position: "bottom-right",
            title: error ?? err.response.data.message,
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 10000,
          });
        });

        if (res.status === 201) {
          let tag = new Tag(res.data.data);
          this.tags.push(tag);

          this.tags = this.tags.sort((a, b) =>
            a.name.toLowerCase() > b.name.toLowerCase() ? 1 : -1
          );

          this.$swal({
            icon: "success",
            position: "bottom-right",
            title: "Tag criada!",
            toast: true,
            showCloseButton: true,
            showConfirmButton: false,
            timer: 10000,
          });
        }
      } else {
        bvModalEvt.preventDefault();
      }
    },
  },
};
</script>
