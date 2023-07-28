<template>
    <div class="box-card">
        <div class="tab-detail pd-tab">
            <h3>Nội dung khóa học</h3>
            <div class="section">
                <div class="s-card" v-for="courseSection, index in courseSections" v-bind:key="index">
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
                        v-for="video, index in courseSection.videos"
                        v-bind:key="index"
                        @click="openVideo($event, video)"
                        v-bind:class="{'active': index === 2 }"
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
        name: 'CourseSection',
        props: {
            setVideoSrc: Function,
            courseSections: Array,
        },
        data() {
            return {
                
            }
        },
        mounted() {
            
        },
        methods: {
            getTotalDuration(videos) {
                var total = 0;

                for (var video in videos) {
                    total += videos[video].duration;
                }

                return total;
            },
            
            openVideo(e, video) {
                e.preventDefault();
                
                this.setVideoSrc(video.source_url);
            },
        }
    }
</script>
