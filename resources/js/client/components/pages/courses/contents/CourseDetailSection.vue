<template>
    <div class="box-card">
        <div class="tab-detail pd-tab">
            <h3>Nội dung khóa học</h3>
            <div class="section">
                <div class="s-card" v-for="courseSection, courseSectionIndex in courseSections" v-bind:key="courseSectionIndex">
                    <div
                        class="sc-theme c-flex cursor-pointer"
                        v-if="courseSection.videos.length != 0"
                    >
                        <div class="name">
                            <i class="fa fa-plus"></i>
                            <div class="n-content">
                                {{ courseSection.name }}
                            </div>
                        </div>
                        <div class="duration total">
                            {{ courseSection.videos.length }} Bài học - {{ this.$helper.formatDuration(getTotalDuration(courseSection.videos)) }}
                        </div>
                    </div>
                    <div
                        class="sc-item c-flex cursor-pointer"
                        v-for="video, videoIndex in courseSection.videos"
                        v-bind:key="videoIndex"
                        @click="openVideo($event, video, `${courseSectionIndex}n${videoIndex}`)"
                        v-bind:class="{'active': (`${courseSectionIndex}n${videoIndex}`) == isVideoActiveVal }"
                    >
                        <div class="name">
                            <i class="fa fa-play"></i>
                            <div class="n-content text-line-2">
                                {{ video.name }}
                            </div>
                        </div>
                        <div class="duration total">
                            {{ this.$helper.formatDuration(video.duration) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CourseDetailSection',
        props: {
            courseSections: Array,
            deVideo: Function,
        },
        data() {
            return {
                isVideoActiveVal: ''
            }
        },
        mounted() {
            
        },
        methods: {
            getTotalDuration(videos) {
                var total = 0;

                for (var video in videos) {
                    total += parseInt(videos[video].duration);
                }

                return total;
            },
            
            async openVideo(e, video, isVideoActiveVal) {
                e.preventDefault();
                
                if (this.$store.state.auth.accessToken == null) {
                    this.$helper.redirectPage('dang-nhap');
                }
                
                if (video.source != null && this.isVideoActiveVal != isVideoActiveVal) {
                    this.$helper.setPageLoading(true);
                    await this.$store.dispatch("getDV", {
                        request: this.$helper.appendFormData({
                            id: video.id
                        }),
                        error: {
                            message: ''
                        }
                    })
                    .then(res => {
                        this.deVideo(video, res.data);
                        this.isVideoActiveVal = isVideoActiveVal;
                    })
                    .catch(err => {
                    });
                    this.$helper.setPageLoading(false);
                }
            },
        }
    }
</script>
