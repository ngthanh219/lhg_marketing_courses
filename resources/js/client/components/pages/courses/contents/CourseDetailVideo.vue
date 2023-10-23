<template>
    <div class="box-card">
        <div class="tab-detail pd-tab">
            <h3>Video</h3>
            <div class="text-center" v-if="!videoSrc">Lựa chọn video để xem</div>

            <div 
                class="video" 
                v-bind:class="[
                    {'active-controls': currentDuration == 0},
                    {'fullscreen': isFullScreen}
                ]" 
                ref="video"
            v-else>
                <canvas
                    class="cursor-pointer"
                    v-bind:class="{'background': !isShowVideo}" 
                    ref="canvas" @click="startVideo"
                />
                <div class="video-controls" id="controls" v-if="video">
                    <div class="option">
                        <div class="left">
                            <a class="cursor-pointer" @click="startVideo">
                                <i class="fas" v-bind:class="[ this.isVideoPlayed ? 'fa-pause' : 'fa-play' ]" />
                            </a>
                            <div class="video-duration">
                                {{ $helper.formatDuration(parseInt(currentDuration)) + ' / ' + $helper.formatDuration(parseInt(totalDuration)) }}
                            </div>
                        </div>
                        <div class="right">
                            <div class="volume">
                                <input type="range" id="range" class="custom-range" min="0" max="1" step="0.1" @input="changeVolumeVideo" v-model="volume" />
                            </div>
                            <a class="cursor-pointer" @click="zoomVideo">
                                <i class="fa fa-expand"></i>
                            </a>
                        </div>
                    </div>
                    <div class="duration-range">
                        <input type="range" id="range" class="custom-range" min="0" :max="totalDuration" step="1" @input="seekVideo($event, null)" v-model="currentDuration" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CourseDetailVideo',
        props: {
            videoSrc: String,
            isLoadVideo: Boolean,
            setIsLoadVideo: Function,
        },
        data() {
            return {
                canvas: {
                    animationFrameId: null,
                    ctx: null,
                    content: null
                },
                video: null,
                volume: 0.3,
                isFullScreen: false,
                isVideoPlayed: false,
                currentDuration: 0,
                totalDuration: 0,
                isShowVideo: false,
                alertMessage: ''
            };
        },
        mounted() {
            
        },
        updated() {
            if (this.isLoadVideo) {
                this.isVideoPlayed = false;
                this.volume = 0.3;
                this.currentDuration = 0;
                this.totalDuration = 0;
                this.clearCanvas();
                this.createCanvas();
                this.setIsLoadVideo(false);
            }

            if (this.isShowVideo && this.isFullScreen) {
                setInterval(this.exitFullScreen(this.$refs.video), 1000);
            }
        },
        beforeUnmount() {
            if (this.video) {
                this.clearCanvas();
            }
        },
        methods: {
            getContext() {
                this.canvas.content = this.$refs.canvas;
                this.canvas.ctx = this.canvas.content.getContext('2d');
            },

            createCanvas() {
                if (this.videoSrc) {
                    this.getContext();
                    this.video = document.createElement('video');
                    this.video.$refs = 'video';
                    this.video.src = this.videoSrc;
                    this.video.volume = this.volume;
                    this.video.setAttribute('preload', 'auto');
                    this.video.playsInline = true;

                    this.video.addEventListener('loadedmetadata', () => {
                        this.canvas.content.width = this.video.videoWidth;
                        this.canvas.content.height = this.video.videoHeight;
                    });

                    this.video.onloadedmetadata = () => {
                        this.animationFrameId = this.drawFrame();
                        this.totalDuration = this.video.duration;
                        this.isShowVideo = true;
                    };
                }
            },

            clearCanvas() {
                this.isShowVideo = false;
                if (this.video) {
                    this.video.pause();
                    cancelAnimationFrame(this.canvas.animationFrameId);
                }
                
                this.getContext();
                this.canvas.ctx.clearRect(0, 0, this.canvas.content.width, this.canvas.content.height);
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
                    if (this.totalDuration > 0) {
                        this.video.play();
                        this.isVideoPlayed = true;
                    }
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
            
            async zoomVideo(e) {
                e.preventDefault();

                this.alertMessage = 'start ';
                try {
                    var element = this.$refs.video;
                    this.alertMessage += '200 ';

                    if (this.isFullScreen) {
                        this.alertMessage += '203 ';
                        this.exitFullScreen(element);
                    } else {
                        this.alertMessage += '206 ';
                        this.enterFullScreen(element);
                    }
                    this.alertMessage += '209 ';
                } catch (err) {
                    this.alertMessage += 'Catch ';
                    this.alertMessage += err;
                }

                alert(this.alertMessage);
            },

            enterFullScreen(element) {
                this.alertMessage += '206.1 ';
                this.isFullScreen = true;
                this.alertMessage += '206.2 ';

                if (element.requestFullscreen) {
                    this.alertMessage += '206.3 ';
                    element.requestFullscreen();
                } else if (element.mozRequestFullScreen) {
                    this.alertMessage += '206.4 ';
                    element.mozRequestFullScreen();
                } else if (element.webkitRequestFullscreen) {
                    this.alertMessage += '206.5 ';
                    element.webkitRequestFullscreen();
                } else if (element.msRequestFullscreen) {
                    this.alertMessage += '206.6 ';
                    element.msRequestFullscreen();
                } else if (element.webkitEnterFullscreen) {
                    this.alertMessage += '206.7 ';
                    element.webkitEnterFullscreen();
                }
                this.alertMessage += '206.8 ';
            },
            
            exitFullScreen() {
                this.alertMessage += '203.1 ';
                this.isFullScreen = false;
                this.alertMessage += '203.2 ';

                if (document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement) {
                    this.alertMessage += '203.3 ';
                    if (document.exitFullscreen) {
                        this.alertMessage += '203.4 ';
                        document.exitFullscreen();
                    } else if (document.mozCancelFullScreen) {
                        this.alertMessage += '203.5 ';
                        document.mozCancelFullScreen();
                    } else if (document.webkitExitFullscreen) {
                        this.alertMessage += '203.6 ';
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) {
                        this.alertMessage += '203.7 ';
                        document.msExitFullscreen();
                    }
                }

                this.alertMessage += '203.8 ';
            },
        }
    }
</script>
