<template>
    <div class="wrapper">
        <MenuBanner
            :pageName="'Tất cả sách'"
        />
        <div class="w-content page">
            <div class="wc-box">
                <div class="title">Tất cả sách</div>

                <BookContent
                    ref="bookContent"

                    :sortValue="sortValue"
                    :setIsShowLoadPage="setIsShowLoadPage"
                />

                <div class="action flex-center" v-if="isShowLoadPage">
                    <button @click="loadBookData" class="btn btn-primary">Xem thêm</button>
                </div>
            </div>
        </div>
        <div class="clear-text"></div>
    </div>
</template>

<script>
    import BookContent from '../../commons/content/BookContent.vue';
    import MenuBanner from '../../commons/banner/MenuBanner.vue';

    export default {
        name: 'BookList',
        components: {
            MenuBanner,
            BookContent
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
            async sortBook(e, val) {
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

                    this.$refs.bookContent.setDataListNull();
                    await this.$refs.bookContent.getBooksDataWithQuery(query);
                    this.$refs.bookContent.checkPage();
                }
            },

            async loadBookData(e) {
                e.preventDefault();

                var data = this.$refs.bookContent.getData();
                var query = data.query;

                if (data.dataList.total_page > query.page) {
                    query.page += 1;
                    await this.$refs.bookContent.getBooksDataWithQuery(query);

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
