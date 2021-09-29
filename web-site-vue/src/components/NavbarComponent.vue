<template>
  <b-navbar
    toggleable="lg"
    type="dark"
    style="background-color: rgb(0, 174, 239)"
  >
    <b-navbar-brand :to="{ path: 'Home' }">xDev</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav class="ml-auto">
        <template v-if="authenticated">
          <b-nav-form>
            <b-input-group size="md">
              <b-input-group-prepend is-text>
                <b-icon icon="search"></b-icon>
              </b-input-group-prepend>
              <b-form-tags
                input-id="tags-separators"
                v-model="value"
                placeholder="Pesquise por tags..."
                remove-on-delete
                style="width: 35rem"
              ></b-form-tags>
            </b-input-group>
            <b-button size="md" class="ml-2" variant="light" type="submit"
              >Procurar</b-button
            >
          </b-nav-form>
        </template>
      </b-navbar-nav>

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <template v-if="authenticated">
          <b-nav-item-dropdown right>
            <template #button-content>
              <span class="mr-2"> {{ user.name }} </span>
              <b-avatar src="https://placekitten.com/300/300"></b-avatar>
            </template>
            <b-dropdown-item>O meu perfil</b-dropdown-item>
            <b-dropdown-item @click.prevent="signOut">Sair</b-dropdown-item>
          </b-nav-item-dropdown>
        </template>

        <template v-else>
          <div class="align-self-center">
            <router-link to="/login" class="text-white mr-2"
              >Entrar</router-link
            >
          </div>
        </template>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  name: "navbar-component",
  mounted() {
    console.log("Navbar component mounted.");
  },
  data() {
    return {
      value: [],
    };
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  methods: {
    ...mapActions({
      signOutAction: "auth/signOut",
    }),

    signOut() {
      this.signOutAction().then(() => {
        this.$router.push("Login").catch(() => {});
      });
    },
  },
};
</script>
