<template>
    <div class="box-card">
        <div class="tab-detail pd-tab">
            <h3>Video</h3>
            <div class="text-center" v-if="!videoSrc">Lựa chọn video để xem</div>
            
            <div class="video" ref="video" v-else>
                <canvas class="cursor-pointer" ref="canvas" @click="startVideo" />
                <div 
                    class="video-controls"
                    id="controls"
                    v-if="video" 
                >
                    <div class="option">
                        <div class="left">
                            <a class="cursor-pointer" @click="startVideo">
                                <i
                                    class="fas"
                                    v-bind:class="[
                                        this.isVideoPlayed ? 'fa-pause' : 'fa-play'
                                    ]"
                                />
                            </a>
                            <div class="video-duration">
                                {{ $helper.formatDuration(parseInt(currentDuration)) + ' / ' + $helper.formatDuration(parseInt(totalDuration)) }}
                            </div>
                        </div>
                        <div class="right">
                            <div class="volume">
                                <input
                                    type="range"
                                    id="range"
                                    class="custom-range"
                                    @input="changeVolumeVideo"
                                    v-model="volume"
                                    min="0"
                                    max="1"
                                    step="0.1"
                                >
                            </div>
                            <a class="cursor-pointer" @click="zoomVideo">
                                <i class="fa fa-expand"></i>
                            </a>
                        </div>
                    </div>
                    <div class="duration-range">
                        <input
                            type="range"
                            id="range"
                            class="custom-range"
                            @input="seekVideo($event, null)"
                            v-model="currentDuration"
                            min="0"
                            :max="totalDuration"
                            step="1"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Video',
        props: {
            videoSrc: String
        },
        data() {
            return {
                isReady: false,
                canvas: {
                    ctx: null,
                    videoWidth: 1920,
                    videoHeight: 1080,
                    content: null
                },
                video: null,
                volume: 0.3,
                isFullScreen: false,
                isVideoPlayed: false,
                currentDuration: 0,
                totalDuration: 0
            };
        },
        mounted() {
            this.createCanvas();
        },
        updated() {
            this.createCanvas();
        },
        methods: {
            createCanvas() {
                if (this.videoSrc) {
                    if (!this.isReady) {
                        this.canvas.content = this.$refs.canvas;
                        this.canvas.ctx = this.canvas.content.getContext('2d');

                        this.video = document.createElement('video');
                        this.video.$refs = 'video';
                        this.video.src = this.videoSrc;
                        this.video.volume = this.volume;
                        this.video.setAttribute('preload', 'auto');

                        this.video.addEventListener('loadedmetadata', () => {
                            this.canvas.content.width = this.canvas.videoWidth;
                            this.canvas.content.height = this.canvas.videoHeight;
                        });

                        this.video.onloadedmetadata = () => {
                            this.drawFrame();
                            this.totalDuration = this.video.duration;
                        };
                    }

                    this.isReady = true;
                }
            },

            drawData(value) {
                this.canvas.ctx.drawImage(value, 0, 0, this.canvas.content.width, this.canvas.content.height);
            },

            drawFrame() {
                this.drawData(this.video);
                this.updateDurationVideo();

                requestAnimationFrame(this.drawFrame);
            },

            startVideo(e) {
                e.preventDefault();

                if (this.currentDuration >= this.totalDuration) {
                    this.currentDuration = 0;
                }

                if (this.video.paused) {
                    this.video.play();
                    this.isVideoPlayed = true;
                } else {
                    this.video.pause();
                    this.isVideoPlayed = false;
                }
                
                this.drawFrame();
            },

            updateDurationVideo() {
                if (this.currentDuration >= this.totalDuration) {
                    this.isVideoPlayed = false;
                } else {
                    this.currentDuration = this.video.currentTime
                }
            },

            seekVideo(e, value) {
                e.preventDefault();

                var newTime = 0;

                if (value != null) {
                    newTime = Math.min(this.video.currentTime + value, this.video.duration);
                } else {
                    newTime = this.currentDuration;
                }

                this.video.currentTime = newTime;
            },

            changeVolumeVideo(e) {
                e.preventDefault();

                this.video.volume = this.volume;
            },
            
            zoomVideo(e) {
                e.preventDefault();

                var element = this.$refs.video;

                if (this.isFullScreen) {
                    this.exitFullScreen(element);
                } else {
                    this.enterFullScreen(element);
                }
            },

            enterFullScreen(element) {
                if (element.requestFullscreen) {
                    element.requestFullscreen();
                } else if (element.mozRequestFullScreen) {
                    element.mozRequestFullScreen();
                } else if (element.webkitRequestFullscreen) {
                    element.webkitRequestFullscreen();
                } else if (element.msRequestFullscreen) {
                    element.msRequestFullscreen();
                }

                this.isFullScreen = true;
            },
            
            exitFullScreen() {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }

                this.isFullScreen = false;
            },
        }
    }
</script>
