<template>
    <div class="wrapper">
        <div class="w-content page">
            <div class="wc-box">
                <div class="title">Tất cả khóa học</div>
                <div class="wc-information">
                    <div class="box-card">
                        <div class="tab-detail">
                            <ul>
                                <li>
                                    <a @click="sortCourse($event, 0)" class="text-center cursor-pointer" v-bind:class="{'active': sortValue == 0}">Mới nhất</a>
                                </li>
                                <li>
                                    <a @click="sortCourse($event, 1)" class="text-center cursor-pointer" v-bind:class="{'active': sortValue == 1}">Giá tăng dần</a>
                                </li>
                                <li>
                                    <a @click="sortCourse($event, 2)" class="text-center cursor-pointer" v-bind:class="{'active': sortValue == 2}">Giá giảm dần</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <CourseContent
                    ref="courseContent"

                    :sortValue="sortValue"
                    :setIsShowLoadPage="setIsShowLoadPage"
                />

                <div class="action flex-center" v-if="isShowLoadPage">
                    <button @click="loadCourseData" class="btn btn-primary">Xem thêm</button>
                </div>
            </div>
        </div>
        <br v-for="index in 16">
    </div>
</template>

<script>
    import CourseContent from '../../commons/content/CourseContent.vue';

    export default {
        name: 'CourseList',
        components: {
            CourseContent
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
            sortCourse(e, val) {
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

                    this.setIsShowLoadPage(true);
                    this.$refs.courseContent.setDataListNull();
                    this.$refs.courseContent.getCoursesDataWithQuery(query);
                }
            },

            async loadCourseData(e) {
                e.preventDefault();

                var data = this.$refs.courseContent.getData();
                var query = data.query;

                if (data.dataList.total_page > query.page) {
                    query.page += 1;
                    await this.$refs.courseContent.getCoursesDataWithQuery(query);

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
