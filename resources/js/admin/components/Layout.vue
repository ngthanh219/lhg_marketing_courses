<template>
    <div class="wrapper">
        <PageLoading v-if="$store.state.isPageLoading" />

        <Header />

        <Menu />

        <router-view></router-view>

        <Footer />
        
        <Notification v-if="$store.state.notification.message" />
    </div>
</template>

<script>
    import Header from './layouts/Header.vue';
    import Menu from './layouts/Menu.vue';
    import Footer from './layouts/Footer.vue';
    import Notification from './commons/notification/Notification.vue';
    import PageLoading from './commons/loading/PageLoading.vue';

    export default {
        name: 'Layout',
        components: {
            Header,
            Menu,
            Footer,
            Notification,
            PageLoading
        },
        mounted() {
            this.$helper.setNotification(0, null);
            this.middleware();
        },
        updated() {
            this.middleware();
        },
        methods: {
            middleware() {
                var auth = this.$store.state.auth;

                if (!auth.accessToken || !auth.user) {
                    this.$helper.redirectPage('login');
                }
            }
        }
    }
</script>
