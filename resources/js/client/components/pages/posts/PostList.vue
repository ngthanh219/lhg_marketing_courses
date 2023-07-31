<template>
    <div class="wrapper">
        <!-- <MenuBanner
            :pageName="'Tất cả bài viết'"
        /> -->
        <div class="w-content page">
            <div class="wc-box">
                <div class="title">Tất cả bài viết</div>

                <PostContent
                    ref="postContent"

                    :sortValue="sortValue"
                    :setIsShowLoadPage="setIsShowLoadPage"
                />

                <div class="action flex-center" v-if="isShowLoadPage">
                    <button @click="loadPostData" class="btn btn-primary">Xem thêm</button>
                </div>
            </div>
        </div>
        <br v-for="index in 16">
    </div>
</template>

<script>
    import PostContent from '../../commons/content/PostContent.vue';
    import MenuBanner from '../../commons/banner/MenuBanner.vue';

    export default {
        name: 'PostList',
        components: {
            PostContent,
            MenuBanner
        },
        data() {
            return {
                sortValue: 0,
                isShowLoadPage: true
            }
        },
        mounted() {

        },
        methods: {
            async sortPost(e, val) {
                e.preventDefault();

                if (this.sortValue != val) {
                    this.sortValue = val;
                    var query = {
                        page: 1,
                        price_sort: ''
                    };

                    if (val == 1) {
                        query.price_sort = 'asc';
                    } else if (val == 2) {
                        query.price_sort = 'desc';
                    }

                    this.$refs.postContent.setDataListNull();
                    await this.$refs.postContent.getPostsDataWithQuery(query);
                    this.$refs.postContent.checkPage();
                }
            },

            async loadPostData(e) {
                e.preventDefault();

                var data = this.$refs.postContent.getData();
                var query = data.query;

                if (data.dataList.total_page > query.page) {
                    query.page += 1;
                    await this.$refs.postContent.getPostsDataWithQuery(query);

                    if (data.dataList.total_page == query.page) {
                        this.setIsShowLoadPage(false);
                    }
                }
            },

            setIsShowLoadPage(val) {
                this.isShowLoadPage = val;
            }
        }
    }
</script>
