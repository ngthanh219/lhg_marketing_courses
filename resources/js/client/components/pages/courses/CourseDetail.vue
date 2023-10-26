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
                    :videoData="videoData"
                    :isLoadVideo="isLoadVideo"
                    :setIsLoadVideo="setIsLoadVideo"
                    :deVideo="deVideo"
                />

                <CourseDetailSection
                    :courseSections="data.course.course_sections"
                    :deVideo="deVideo"
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
                videoData: null,
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
            
            setIsLoadVideo(val) {
                this.isLoadVideo = val;
            },

            setVideoSrc(videoSrc) {
                this.isLoadVideo = true;
                this.videoSrc = videoSrc;
                console.log(this.videoSrc);
            },

            async deVideo(video, data) {
                this.videoData = video;
                var source = video.source;
                const items = source.split('%');
                for (let i in items) {
                    items[i] = items[i].split('').reverse().join('');
                }

                const temp = items[0];
                var thirdItem = '';
                items[0] = items[1];
                items[1] = temp;

                if (items[2]) {
                    thirdItem = items[2];
                }

                source = items[0] + items[1] + thirdItem;
                var newData = {};

                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        newData["X-Amz-" + key] = data[key];
                    }
                }

                var expiresKey = 'X-Amz-Expires';
                if (!data.hasOwnProperty(expiresKey)) {
                    newData[expiresKey] = parseInt(video.duration) + 300;
                }

                var query = this.$helper.getQueryString(newData);
                this.setVideoSrc(this.$env.s3Url + 'videos/' + source + '.mp4' + query);
            }
        }
    }
</script>
