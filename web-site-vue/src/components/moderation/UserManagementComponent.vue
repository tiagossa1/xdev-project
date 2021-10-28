<template>
  <div>
    <h5 class="mb-3 font-weight-bold">Gestão de utilizadores</h5>
    <b-table
      ref="userTable"
      sticky-header="500px"
      table-variant="light"
      striped
      bordered
      borderless
      outlined
      :fields="userFields"
      :items="users"
      :tbody-tr-class="rowClass"
    >
      <template #cell(actions)="data">
        <b-button
          class="m-1 text-white"
          @click="onDetailsClick(data.item)"
          variant="primary"
          >Detalhes</b-button
        >
        <b-button class="m-1" @click="onEditClick(data.item)" variant="warning"
          >Editar</b-button
        >
        <b-button
          class="m-1 text-white"
          v-if="data.item.id !== $store.getters['auth/user'].id"
          @click="onSuspended(data.item)"
          :variant="data.item.suspended ? 'success' : 'danger'"
        >
          {{ data.item.suspended ? "Remover suspensão" : "Suspender" }}
        </b-button>
      </template>
      <!-- eslint-disable-next-line -->
      <template #cell(userType.name)="data">
        <span
          class="font-weight-bold"
          :style="{ color: data.item.userType.hexColorCode }"
        >
          {{ data.item.userType.name }}
        </span>
      </template>
    </b-table>

    <b-modal ref="details-modal" scrollable hide-footer title="Detalhes">
      <div class="d-block">
        <user-information-component
          :user="userSelected"
        ></user-information-component>
      </div>
      <b-button
        class="mt-3"
        variant="outline-primary"
        @click="$refs['details-modal'].hide()"
        block
        >Fechar</b-button
      >
    </b-modal>

    <b-modal
      @close="onCloseEdit"
      ref="edit-modal"
      scrollable
      hide-footer
      title="Editar"
    >
      <div class="d-block">
        <user-information-component
          :user="userSelected"
          :viewOnly="false"
          @form-status="onFormStatus"
        ></user-information-component>
      </div>
      <b-button
        class="mt-3"
        variant="outline-danger"
        :disabled="!isEditFormValid"
        @click="onEditButtonClick"
        block
        >Editar</b-button
      >
    </b-modal>
  </div>
</template>

<script>
import User from "../../models/user";
import UserRequest from "../../models/requests/userRequest";

import userService from "../../services/userService";

import UserInformationComponent from "./UserInformationComponent.vue";

export default {
  name: "user-management-component",
  components: { UserInformationComponent },
  data() {
    return {
      userFields: [
        { key: "name", label: "Nome" },
        "email",
        { key: "userType.name", label: "Tipo" },
        { key: "actions", label: "Ações" },
      ],
      users: [],
      userTypeSelected: null,
      userSelected: { district: {}, userType: {}, schoolClass: {} },
      isEditFormValid: false,
    };
  },
  methods: {
    rowClass(item, type) {
      if (!item || type !== "row") return;
      if (item.suspended) return "table-danger";
    },
    onDetailsClick(user) {
      this.userSelected = this.users.find((u) => u.id == user.id);
      // this.userSelected = user;
      this.$refs["details-modal"].show();
    },
    onEditClick(user) {
      this.userSelected = this.users.find((u) => u.id == user.id);
      this.$refs["edit-modal"].show();
    },
    onFormStatus(isFormValid) {
      this.isEditFormValid = isFormValid;
    },
    async onEditButtonClick() {
      const request = new UserRequest(
        this.userSelected.id,
        this.userSelected.email,
        this.userSelected.name,
        this.userSelected.birth_date,
        null,
        this.userSelected.github_url,
        this.userSelected.linkedin_url,
        this.userSelected.facebook_url,
        this.userSelected.instagram_url,
        null,
        null,
        null,
        this.userSelected.userType.id,
        null,
        null,
        null,
        null,
        this.userSelected.suspended
      );

      const res = await userService.update(request).catch((err) => {
        this.$swal({
          icon: "error",
          position: "bottom-right",
          title: err.response,
          toast: true,
          showCloseButton: true,
          showConfirmButton: false,
          timer: 10000,
        });
      });

      if (res.status === 200) {
        const userEdited = new User(res.data.data);
        const index = this.users.findIndex((u) => u.id === userEdited.id);

        if (index > -1) {
          this.users[index] = userEdited;
          this.$refs.userTable.refresh();
        }

        this.$refs["edit-modal"].hide();
        this.$swal({
          icon: "success",
          position: "bottom-right",
          title: "Utilizador editado.",
          toast: true,
          showCloseButton: true,
          showConfirmButton: false,
          timer: 10000,
        });
      }
    },
    async onCloseEdit() {
      let res = await userService.getUserById(this.userSelected.id);
      let userIndex = this.users.findIndex(
        (u) => u.id === this.userSelected.id
      );

      this.users[userIndex] = res;
      this.$refs.userTable.refresh();
    },
    async onSuspended(user) {
      this.$swal({
        title: "Confirmação",
        text: "Deseja mesmo suspender o utilizador?",
        showCancelButton: true,
        confirmButtonText: "Suspender",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#dc3545",
      }).then(async (result) => {
        if (result.isConfirmed) {
          const request = new UserRequest(
            user.id,
            user.email,
            user.name,
            user.birth_date,
            user.profile_picture,
            user.github_url,
            user.linkedin_url,
            user.facebook_url,
            user.instagram_url,
            user.createdAt,
            user.district.id,
            user.schoolClass.id,
            user.userType.id,
            null,
            null,
            null,
            null,
            !user.suspended
          );

          const res = await userService.update(request).catch((err) => {
            this.$swal({
              icon: "error",
              position: "bottom-right",
              title: err.response.data.message,
              toast: true,
              showCloseButton: true,
              showConfirmButton: false,
              timer: 10000,
            });
          });

          if (res.status === 200) {
            let user = new User(res.data.data);
            let index = this.users.findIndex((u) => u.id === user.id);

            if (user && index >= 0) {
              this.users[index] = user;
            }

            this.$refs.userTable.refresh();
            this.$swal({
              icon: "success",
              position: "bottom-right",
              title: user.suspended
                ? "Utilizador suspenso."
                : "A suspensão foi removida.",
              toast: true,
              showCloseButton: true,
              showConfirmButton: false,
              timer: 10000,
            });
          }
        }
      });
    },
  },
  async mounted() {
    this.users = await userService.getUsers();
    this.usersSelected = await userService.getUserTypes();
  },
};
</script>

<style scoped>
footer {
  bottom: 0;
}
</style>
