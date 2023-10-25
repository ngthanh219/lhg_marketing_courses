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
                v-else
            >
                <canvas
                    class="cursor-pointer"
                    v-bind:class="{'background': !isShowVideo}" 
                    ref="canvas" @click="startVideo"
                />
                <div class="video-controls" id="controls" v-if="video">
                    <div
                        class="duration-range"
                        ref="durationRange"
                        @mousedown="startDraggingDuration"
                        @mouseup="stopDraggingDuration"
                        @mouseleave="stopDraggingDuration"
                        @mousemove="updateDuration($event, false)"
                        @click="updateDuration($event, true)"
                    >
                        <div
                            class="c-duration"
                            :style="'width: ' + ((currentDuration == totalDuration) ? 100 : (currentDuration * 100 / totalDuration)) + '%'"
                        />
                    </div>
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
                                <i
                                    class="cursor-pointer fa"
                                    v-bind:class="[ volume * 100 > 10 ? 'fa-volume-off' : 'fa-volume-mute' ]"
                                    @click="updateVolume($event, false, true)"
                                />
                                <div
                                    class="duration-range volume"
                                    ref="volumeRange"
                                    @mousedown="startDraggingVolume"
                                    @mouseup="stopDraggingVolume"
                                    @mouseleave="stopDraggingVolume"
                                    @mousemove="updateVolume($event, false)"
                                    @click="updateVolume($event, true)"
                                >
                                    <div
                                        class="c-duration"
                                        :style="'width: ' + (volume * 100) + '%'"
                                    />
                                </div>
                            </div>
                            <a class="cursor-pointer" @click="zoomVideo">
                                <i class="fa fa-expand"></i>
                            </a>
                        </div>
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
                isDraggingDuration: false,
                isDraggingVolume: false,
                volumeTemp: 0.3
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

            updateVideoDuration() {
                if (this.currentDuration >= this.totalDuration) {
                    this.isVideoPlayed = false;
                } else {
                    this.currentDuration = this.video.currentTime
                }
            },

            drawData(value) {
                this.canvas.ctx.drawImage(value, 0, 0, this.canvas.content.width, this.canvas.content.height);
            },

            drawFrame() {
                this.drawData(this.video);
                this.updateVideoDuration();

                requestAnimationFrame(this.drawFrame);
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

            startDraggingDuration() {
                this.isDraggingDuration = true;
            },

            stopDraggingDuration() {
                this.isDraggingDuration = false;
            },

            updateDuration(e, isClick = false) {
                const timeBar = this.$refs.durationRange.getBoundingClientRect();
                const width = e.clientX - timeBar.left;
                const maxWidth = timeBar.width;
                const percentage = (width / maxWidth) * 100;
                const eleDuration = this.totalDuration * percentage / 100;

                if (this.isDraggingDuration || isClick) {
                    this.video.currentTime = eleDuration;
                }

                if (!this.isVideoPlayed && isClick) {
                    this.video.currentTime = eleDuration;
                    this.currentDuration = eleDuration;
                    this.video.play();
                    this.isVideoPlayed = true;
                }
            },

            startDraggingVolume() {
                this.isDraggingVolume = true;
            },

            stopDraggingVolume() {
                this.isDraggingVolume = false;
            },

            updateVolume(e, isClick = false, isMute = false) {
                e.preventDefault();

                if (isMute) {
                    if (this.video.volume == 0) {
                        this.video.volume = this.volumeTemp;
                        this.volume = this.volumeTemp;
                    } else {
                        this.volumeTemp = this.video.volume;
                        this.video.volume = 0;
                        this.volume = 0.1;
                    }
                } else {
                    var timeBar = this.$refs.volumeRange.getBoundingClientRect();
                    var width = e.clientX - timeBar.left;
                    var maxWidth = timeBar.width;
                    var percentage = parseInt((width / maxWidth) * 100) / 100;
                    var eleVolume = percentage < 0 ? 0 : percentage;

                    if ((this.isDraggingVolume && !isClick) || (!this.isDraggingVolume && isClick)) {
                        this.video.volume = eleVolume;
                        this.volume = eleVolume;

                        if (this.volume >= 0.99 || this.volume == 0.01) {
                            this.stopDraggingVolume();
                        }

                        if (this.volume <= 0.1) {
                            this.video.volume = 0;
                            this.volume = 0.1;
                        }

                        if (this.volume >= 0.95) {
                            this.video.volume = 1;
                            this.volume = 1;
                        }
                    }
                }
            },

            changeVolumeVideo(e) {
                e.preventDefault();

                this.video.volume = this.volume;
            },
            
            zoomVideo(e) {
                e.preventDefault();

                if (this.isFullScreen) {
                    this.isFullScreen = false;
                } else {
                    this.isFullScreen = true;
                }

                // var element = this.$refs.video;

                // if (this.isFullScreen) {
                //     this.exitFullScreen(element);
                // } else {
                //     this.enterFullScreen(element);
                // }
            },

            enterFullScreen(element) {
                this.isFullScreen = true;

                // if (element.requestFullscreen) {
                //     element.requestFullscreen();
                // } else if (element.mozRequestFullScreen) {
                //     element.mozRequestFullScreen();
                // } else if (element.webkitRequestFullscreen) {
                //     element.webkitRequestFullscreen();
                // } else if (element.msRequestFullscreen) {
                //     element.msRequestFullscreen();
                // } else if (element.webkitEnterFullscreen) {
                //     element.webkitEnterFullscreen();
                // }
            },
            
            exitFullScreen() {
                this.isFullScreen = false;

                if (document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement) {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                }
            },
        }
    }
</script>
