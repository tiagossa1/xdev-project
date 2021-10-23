<template>
  <div>
    <p class="h5 font-weight-bold mb-3">Gestão de Tags <b-icon class="text-primary cursor-pointer" icon="plus"></b-icon></p>
    <b-table
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
        <b-button-group>
          <b-button @click="onEditTag(data.item)" variant="warning"
            >Editar</b-button
          >
          <b-button @click="onDeleteTag(data.item.id)" variant="danger">
            Eliminar
          </b-button>
        </b-button-group>
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
      let res = await tagService.update(this.tagSelected.id, req);

      if (res.status === 200) {
        let tagEdited = new Tag(res.data.data);
        let index = this.tags.findIndex((t) => t.id === this.tagSelected.id);

        if (index > -1) {
          this.tags[index] = tagEdited;
          this.tags = this.tags.sort((a, b) =>
            a.name.toLowerCase() > b.name.toLowerCase() ? 1 : -1
          );
        }
      }
    },
    async onDeleteTag(id) {
      const res = await tagService.delete(id);

      if (res.status === 200) {
        const index = this.tags.findIndex((t) => t.id === id);

        if (index > -1) {
          this.tags.splice(index, 1);
        }
      }
    },
    async onClick() {
      let req = new TagRequest(this.form.name, null);
      let res = await tagService.create(req);

      if (res.status === 201) {
        let tag = new Tag(res.data.data);
        this.tags.push(tag);

        this.tags = this.tags.sort((a, b) =>
          a.name.toLowerCase() > b.name.toLowerCase() ? 1 : -1
        );
      }
    },
  },
};
</script>