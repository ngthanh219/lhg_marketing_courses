<template>
    <div class="card-list">
        <div class="card-item" v-if="dataList" v-for="data in dataList.list">
            <router-link :to="'/' + data.slug">
                <div class="c-image">
                    <img :src="data.image_url" alt="">
                    <label class="percent-off-label" v-if="data.discount > 0">
                        <strong>-{{ data.discount }}% </strong>
                    </label>
                </div>
                <div class="c-info">
                    <div class="theme text-line-2">{{ data.name }}</div>
                    <div class="detail">
                        <div class="lecture">
                            <div class="name">
                                Khóa học
                            </div>
                            <div class="rate">
                                <i class="fas fa-fw fa-star" v-for="index in 5"></i>
                            </div>
                        </div>
                        <div class="price">
                            <span class="old" v-if="data.discount != 0">
                                <del>
                                    {{ parseInt(data.price).toLocaleString() }}<sup>đ</sup>
                                </del>
                            </span>
                            <span class="discount">
                                <del>
                                    {{ data.discount != 0 ? parseInt(data.discount_price).toLocaleString() : parseInt(data.price).toLocaleString() }}<sup>đ</sup>
                                </del>
                            </span>
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
        name: 'CourseContent',
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
                    price_sort: "",
                    name: "",
                    is_user: false
                },
                formDataError: {
                    message: ""
                },
            };
        },
        async mounted() {
            await this.getCoursesData();

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

            async getCoursesDataWithQuery(query) {
                this.$helper.mergeArrayData(query, this.query);

                await this.getCoursesData();
            },

            async getCoursesData() {
                this.$helper.setPageLoading(true);
                await this.$store.dispatch("getCourses", {
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
