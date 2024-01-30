<template>
    <div class="card-list">
        <div class="card-item" v-if="dataList" v-for="book in dataList.list">
            <router-link :to="'giao-trinh/' + book.slug">
                <div class="c-image">
                    <img :src="book.image[0]" alt="">
                </div>
                <div class="c-info">
                    <div class="theme text-line-3">{{ book.name }}</div>
                    <div class="description text-line-3" v-html="book.introduction">
                    </div>
                    <div class="detail" style="flex-direction: row-reverse;">
                        <a class="btn btn-success show">
                            Chi tiết <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </router-link>
        </div>
        <div class="card-item" v-else v-for="index in 6">
            <br v-for="index in 16">
        </div>
    </div>
</template>

<script>
export default {
    name: 'BookContent',
    props: {
        filterValue: Number,
        setIsShowLoadPage: Function
    },
    data() {
        return {
            dataList: null,
            query: {
                limit: 15,
                page: 1,
                id_sort: "desc",
                name: ""
            },
            formDataError: {
                message: ""
            }
        }
    },
    async mounted() {
        await this.getBooksData();

        this.checkPage();
    },
    methods: {
        checkPage() {
            if (typeof(this.setIsShowLoadPage) === 'function') {
                if (this.dataList.total_page <= 1) {
                    this.setIsShowLoadPage(false);
                } else {
                    this.setIsShowLoadPage(true);
                }
            }
        },
        
        setDataListNull() {
            this.dataList = null;
        },

        getData() {
            return {
                dataList: this.dataList,
                query: this.query
            };
        },

        async getBooksDataWithQuery(query) {
            this.$helper.mergeArrayData(query, this.query);

            await this.getBooksData();
        },

        async getBooksData() {
            this.$helper.setPageLoading(true);
            await this.$store.dispatch("getBooks", {
                query: this.$helper.getQueryString(this.query),
                error: this.formDataError
            })
            .then(res => {
                if (this.dataList == null) {
                    this.dataList = res.data;
                } else {
                    for (var index in res.data.list) {
                        this.dataList.list.push(res.data.list[index]);
                    }
                }

            })
            .catch(err => {
            });
            this.$helper.setPageLoading(false);
        }
    }
}
</script>
