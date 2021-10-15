<template>
    <b-card-group deck class="mb-3 text-center">
        <b-card border-variant="light">
            <template #header>
                <span class="font-weight-bold text-primary">Tags Populares</span>
            </template>
            <b-card-text>
                <b-badge class="m-2 text-white p-2" pill variant="primary" v-for="popularTag in popularTags" :key="popularTag.name">
                {{popularTag.name}}
                </b-badge>
            </b-card-text>
        </b-card>
    </b-card-group>
</template>

<script>
import tagService from "../services/tagService";
export default {
    name: 'popularTags-component',
    data(){
        return {
            popularTags : null
        }
    },
    async created(){
        let popularTags = await tagService.getTags();
        this.popularTags = popularTags.slice(0, 5);
    }
}

</script>

<style>

</style>