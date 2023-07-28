<template>
    <div class="card-list">
        <div class="card-item" v-if="dataList" v-for="data in dataList.list">
            <router-link :to="'/' + data.slug">
                <div class="c-image">
                    <img :src="data.image_url" alt="">
                </div>
                <div class="c-info">
                    <div class="theme text-line-2">{{ data.name }}</div>
                    <div class="detail">
                        <div class="lecture">
                            <div class="name">Nguyễn Thành</div>
                            <div class="rate">
                                <i class="fas fa-fw fa-star" v-for="index in 5"></i> (6)
                            </div>
                        </div>
                        <div class="price">
                            <span class="old" v-if="data.discount != 0">
                                <del>
                                    {{ data.price.toLocaleString() }}<sup>đ</sup>
                                </del>
                            </span>
                            <span class="discount">
                                <del>
                                    {{ data.discount != 0 ? data.discount_price.toLocaleString() : data.price.toLocaleString() }}<sup>đ</sup>
                                </del>
                            </span>
                        </div>
                    </div>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CourseContent',
        data() {
            return {
                dataList: null,
                query: {
                    limit: 15,
                    page: 1,
                    id_sort: "desc",
                    name: "",
                    is_deleted: 0
                },
                formDataError: {
                    message: ""
                }
            };
        },
        async mounted() {
            this.$helper.getCurrentQuery(this.query);

            await this.getCoursesData();
        },
        methods: {
            async getCoursesData() {
                this.$helper.setPageLoading(true);
                await this.$store.dispatch("getCourses", {
                    query: this.$helper.getQueryString(this.query),
                    error: this.formDataError
                })
                .then(res => {
                    this.dataList = res.data;
                })
                .catch(err => {
                });
                this.$helper.setPageLoading(false);
            },

            filter(e) {
                e.preventDefault();

                this.$helper.pushQueryUrl(this.query);

                if (this.query.page >= this.dataList.total_page) {
                    this.query.page = this.dataList.total_page;
                }

                if (this.query.page == 0) {
                    this.query.page = 1;
                }

                this.getCourseData();
            }
        }
    }
</script>
