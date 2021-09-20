<template>
    <!--<footer class="mt-auto bg-primary" style="height: 100px; margin-top:20px; display:flex; align-items:center;">
        <div class="m-4">
            <h2 class="float-left font-weight-bold">ATEC</h2> <span class="ml-2">© {{ new Date().getFullYear() }}</span>
        </div>
    </footer>-->
    <footer class="footer">
        <div>
            <h2 class="float-left font-weight-bold">ATEC</h2> <span class="ml-2">© {{ new Date().getFullYear() }}</span>
        </div>
    </footer>
</template>

<style scoped>
    footer{
        background-color: #00AEEF;

        position: absolute;
        margin-top:20px;
        display:flex;
        align-items:center;
        padding: 5px;

        bottom: 0;
        width: 100%;
        height: 50px;
    }
</style>


<script>
export default {
    name: "footer-component",
    mounted() {
        console.log('Footer component mounted.')
    }
}
</script>


