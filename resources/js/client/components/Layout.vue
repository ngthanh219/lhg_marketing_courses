<template>
    <div class="wrapper-app">
        <PageLoading v-if="$store.state.isPageLoading" />

        <Header />

        <div class="container-wrapper">
            <router-view></router-view>
        </div>

        <Footer />
        
        <Notification v-if="$store.state.notification.message" />
    </div>
</template>

<script>
    import Header from './layouts/Header.vue';
    import Footer from './layouts/Footer.vue';
    import Notification from './commons/notification/Notification.vue';
    import PageLoading from './commons/loading/PageLoading.vue';

    export default {
        name: 'Layout',
        components: {
            Header,
            Footer,
            Notification,
            PageLoading
        },
        mounted() {
            this.$helper.setNotification(0, null);
            // this.middleware();
        },
        updated() {
            this.middleware();
        },
        methods: {
            middleware() {
                if (this.$store.state.auth.accessToken) {
                    this.$store.dispatch("getInfo", {
                        error: {
                            message: ''
                        }
                    })
                    .then(res => {
                        
                    })
                    .catch(err => {
                    });
                }
            }
        }
    }
</script>
