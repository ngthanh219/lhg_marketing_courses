<template>
    <div class="card-list">
        <div class="card-item" v-if="dataList" v-for="post in dataList.list">
            <router-link :to="'bai-viet/' + post.slug">
                <div class="c-image">
                    <img :src="post.image_url" alt="">
                </div>
                <div class="c-info">
                    <div class="theme text-line-3">{{ post.name }}</div>
                    <div class="detail">
                        <div class="decription text-line-2">
                            {{ post.content }}
                        </div>
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
    name: 'PostContent',
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
                id_sort: "",
                name: ""
            },
            formDataError: {
                message: ""
            },
        };
    },
    async mounted() {
        await this.getPostsData();

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

        async getPostsDataWithQuery(query) {
            this.$helper.mergeArrayData(query, this.query);

            await this.getPostsData();
        },

        async getPostsData() {
            this.$helper.setPageLoading(true);
            await this.$store.dispatch("getPosts", {
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
