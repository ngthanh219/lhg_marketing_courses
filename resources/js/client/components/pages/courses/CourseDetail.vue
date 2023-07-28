<template>
    <div class="wrapper grey-br" v-if="data">
        <MenuBanner
            :pageName="data.course.name"
            :slogan="data.course.slogan"
        />

        <div class="w-content c-detail page">
            <div class="wc-information">
                <div class="box-card">
                    <div class="tab-detail pd-tab">
                        <h3>Giới thiệu khóa học</h3>
                        <div class="description">
                            {{ data.course.introduction }}
                        </div>
                    </div>
                </div>
                <div class="box-card">
                    <div class="tab-detail pd-tab">
                        <h3>Bạn sẽ học được gì</h3>
                        <div class="description">
                            {{ data.course.description }}
                        </div>
                    </div>
                </div>

                <Video 
                    :videoSrc="videoSrc"
                />

                <CourseSection
                    :courseSections="data.course.course_sections"
                    :setVideoSrc="setVideoSrc"
                />
            </div>
            <div class="wc-general-information">
                <div class="gi-card">
                    <div class="gic-image">
                        <img :src="data.course.image_url" alt="">
                    </div>
                    <div class="gic-action">
                        <div class="price-box-theme">
                            <div class="price">
                                <strong>
                                    {{ data.course.discount != 0 ? data.course.discount_price.toLocaleString() : data.course.price.toLocaleString() }}<sup>đ</sup>
                                </strong>
                                <del v-if="data.course.discount != 0">
                                    {{ data.course.price.toLocaleString() }}<sup>đ</sup>
                                </del>
                            </div>
                            <span class="discount-price">-{{ data.course.discount }}%</span>
                        </div>
                        <div class="btn-action">
                            <router-link to="/hoc-tiktok/dang-ky" class="btn btn-danger">Đăng ký học</router-link>
                        </div>
                    </div>
                    <div class="gic-info">
                        <div class="gic-info-item">
                            <i class="fa fa-clock"></i>
                            Thời lượng: 
                            <strong>{{ this.$helper.formatDuration(data.total_video_duration) }}</strong>
                        </div>
                        <div class="gic-info-item">
                            <i class="fa fa-play"></i>
                            Giáo trình: 
                            <strong>{{ data.total_course_section }} bài giảng</strong>
                        </div>
                        <div class="gic-info-item">
                            <i class="fa fa-globe"></i>
                            Học mọi lúc mọi nơi
                        </div>
                        <div class="gic-info-item">
                            <i class="fa fa-mobile-alt"></i>
                            Học trên mọi thiết bị: Mobile, TV, PC
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MenuBanner from '../../commons/banner/MenuBanner.vue';
    import Video from '../../commons/content/Video.vue';
    import CourseSection from '../../commons/content/CourseSection.vue';

    export default {
        name: 'CourseDetail',
        components: {
            MenuBanner,
            Video,
            CourseSection
        },
        data() {
            return {
                videoSrc: '',
                data: null,
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
            await this.getCourseData();
        },
        methods: {
            async getCourseData() {
                this.$helper.setPageLoading(true);
                await this.$store.dispatch("getCourseDetail", {
                    slug: this.$route.params.courseSlug,
                    error: this.formDataError
                })
                .then(res => {
                    this.data = res.data;
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
            },

            setVideoSrc(videoSrc) {
                this.videoSrc = videoSrc;
            }
        }
    }
</script>
