<template>
    <div>
        <footer :style="footerStyle">
            <div>
                <h2 class="float-left font-weight-bold">ATEC</h2> <span class="ml-2 small">© {{ new Date().getFullYear() }}</span>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
    name: 'footer-component',
    data() {
        return {
            footerStyle: {
                backgroundColor: '#00AEEF',
                position: 'absolute',
                marginTop: '20px',
                display: 'flex',
                alignItems: 'center',
                padding: '5px',

                bottom: '0',
                width: '100%',
                height: '50px',
            }
        }
    },
    mounted() {
        console.log('Footer component mounted.')
    }
}
</script>


