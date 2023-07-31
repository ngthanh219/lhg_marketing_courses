<template>
    <div class="wrapper" v-if="data">
        <MenuBanner
            :pageName="data.name"
        />

        <div class="w-content page">
            <div class="wc-box">
                <div class="wc-information">
                    <div class="box-card">
                        <div class="tab-detail no-border">
                            <div class="description" v-html="data.content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br v-for="index in 50">
</template>

<script>
    import MenuBanner from '../../commons/banner/MenuBanner.vue';

    export default {
        name: 'PostDetail',
        components: {
            MenuBanner
        },
        data() {
            return {
                data: null,
                formDataError: {
                    message: ""
                }
            };
        },
        async mounted() {
            await this.getPostData();
        },
        methods: {
            async getPostData() {
                this.$helper.setPageLoading(true);
                await this.$store.dispatch("getPostDetail", {
                    slug: this.$route.params.postSlug,
                    error: this.formDataError
                })
                .then(res => {
                    this.data = res.data;
                })
                .catch(err => {
                });
                this.$helper.setPageLoading(false);
            }
        }
    }
</script>
