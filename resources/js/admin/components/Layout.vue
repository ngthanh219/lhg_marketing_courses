<template>
    <div class="wrapper">
        <Header />

        <Menu />

        <router-view></router-view>

        <Footer />
    </div>
</template>

<script>
    import Header from './layouts/Header.vue';
    import Menu from './layouts/Menu.vue';
    import Footer from './layouts/Footer.vue';

    export default {
        name: 'Layout',
        components: {
            Header,
            Menu,
            Footer,
        },
        mounted() {
            var auth = this.$store.state.auth;

            if (!auth.accessToken || !auth.user) {
                this.$router.push({path: '/admin/login' });
            }
        }
    }
</script>
