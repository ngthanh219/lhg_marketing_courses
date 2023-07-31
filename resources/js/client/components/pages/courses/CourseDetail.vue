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
                        <div class="description" v-html="data.course.description"></div>
                    </div>
                </div>

                <CourseDetailVideo 
                    :videoSrc="videoSrc"
                    :isLoadVideo="isLoadVideo"
                    :setIsLoadVideo="setIsLoadVideo"
                />

                <CourseDetailSection
                    :courseSections="data.course.course_sections"
                    :setVideoSrc="setVideoSrc"
                />
            </div>

            <CourseDetailRegister
                :courseDetailData="data"
            />
        </div>
    </div>
    <br v-else v-for="index in 50">
</template>

<script>
    import MenuBanner from '../../commons/banner/MenuBanner.vue';
    import CourseDetailVideo from './contents/CourseDetailVideo.vue';
    import CourseDetailSection from './contents/CourseDetailSection.vue';
    import CourseDetailRegister from './contents/CourseDetailRegister.vue';

    export default {
        name: 'CourseDetail',
        components: {
            MenuBanner,
            CourseDetailVideo,
            CourseDetailSection,
            CourseDetailRegister,
        },
        data() {
            return {
                videoSrc: '',
                isLoadVideo: false,
                data: null,
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

            setVideoSrc(videoSrc) {
                this.isLoadVideo = true;
                this.videoSrc = videoSrc;
            },
            
            setIsLoadVideo(val) {
                this.isLoadVideo = val;
            }
        }
    }
</script>
