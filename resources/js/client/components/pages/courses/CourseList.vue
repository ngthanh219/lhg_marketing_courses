<template>
    <div class="wrapper">
        <MenuBanner
            :pageName="'Khóa học'"
        />
        <div class="w-content page">
            <div class="wc-box">
                <div class="wc-information">
                    <div class="box-card flex-center">
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
                                <li>
                                    <a @click="sortCourse($event, 3)" class="text-center cursor-pointer" v-bind:class="{'active': sortValue == 3}">Khóa học của tôi</a>
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
        <div class="clear-text"></div>
    </div>
</template>

<script>
    import CourseContent from '../../commons/content/CourseContent.vue';
    import MenuBanner from '../../commons/banner/MenuBanner.vue';

    export default {
        name: 'CourseList',
        components: {
            CourseContent,
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
            async sortCourse(e, val) {
                e.preventDefault();

                if (this.sortValue != val) {
                    this.sortValue = val;
                    var query = {
                        page: 1,
                        price_sort: '',
                        is_user: false
                    };

                    if (val == 1) {
                        query.price_sort = 'asc';
                    } else if (val == 2) {
                        query.price_sort = 'desc';
                    } else if (val == 3) {
                        query.is_user = true;
                    }

                    this.$refs.courseContent.setDataListNull();
                    await this.$refs.courseContent.getCoursesDataWithQuery(query);
                    this.$refs.courseContent.checkPage();
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
