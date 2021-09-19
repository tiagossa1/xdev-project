<template>
    <b-navbar toggleable="lg" type="dark" variant="primary">
        <b-navbar-brand>xDev</b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav class="ml-auto">
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
                    <b-button size="md" class="ml-2" variant="light" type="submit">Procurar</b-button>
                </b-nav-form>
            </b-navbar-nav>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">
                <b-nav-item-dropdown right>
                    <template #button-content>
                        <span class="mr-2">UsernamePlaceholder</span> <b-avatar src="https://placekitten.com/300/300"></b-avatar>
                    </template>
                    <b-dropdown-item>O meu perfil</b-dropdown-item>
                    <b-dropdown-item >Sair</b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
export default {
    name: "navbar-component",
    mounted() {
        console.log('Navbar component mounted.')
    },
    props: ['isLogged']
}
</script>
