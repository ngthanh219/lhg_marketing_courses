<template>
    <div class="wrapper grey-br">
        <ThirdBanner />

        <div class="w-content c-detail page">
            <div class="wc-information">
                <div class="box-card">
                    <div class="tab-detail">
                        <ul>
                            <li>
                                <a href="#">Giới thiệu</a>
                            </li>
                            <li>
                                <a href="#">Nội dung</a>
                            </li>
                            <li>
                                <a href="#">Đánh giá</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="box-card">
                    <div class="tab-detail pd-tab">
                        <h3>Giới thiệu khóa học</h3>
                        <div class="description">
                            Hiện nay, các thương hiệu trên thế giới cũng rất thường xuyên sử dụng các video trên Youtube để tăng nhận diện thương hiệu của mình. Sự phát triển của Youtube rất mạnh. Hành vi sử dụng Youtube tăng cao và số thời gian ở lại lâu là một lợi thế lớn để các doanh nghiệp. Vì thế, đây là một kênh mà bạn cần khai thác vô cùng mạnh mẽ.
                            Nhưng hầu hết các kênh hiện nay đều dính tới bản quyền nếu chưa tìm hiểu cặn kẽ, chia sẻ các cách tạo video, lên ý tưởng cũng như thực hành ra video hoàn chỉnh.
                        </div>
                    </div>
                </div>
                <div class="box-card">
                    <div class="tab-detail pd-tab">
                        <h3>Bạn sẽ học được gì</h3>
                        <div class="description">
                            Tham gia đăng ký ngay khóa học "Youtube Marketing" ngay hôm nay để đột phá doanh số bán hàng và gia tăng thương hiệu của mình! 
                        </div>
                    </div>
                </div>
                <div class="box-card">
                    <div class="tab-detail pd-tab">
                        <h3>Video</h3>
                        <div class="text-center">Lựa chọn video để xem</div>
                        
                        <canvas class="cursor-pointer" ref="canvas" @click="startVideo"></canvas>
                        <button class="btn btn-primary" @click="seekVideo($event, -5)">- 5s</button>
                        <button class="btn btn-primary" @click="seekVideo($event, +5)">+ 5s</button>
                        <input type="range" @input="changeVolumnVideo" v-model="volume" min="0" max="1" step="0.1">
                        <button class="btn btn-primary" @click="zoomVideo">Zoom video</button>
                    </div>
                </div>
                <div class="box-card">
                    <div class="tab-detail pd-tab">
                        <h3>Nội dung khóa học</h3>
                        <div class="section">
                            <div class="s-card" v-for="index in 2">
                                <div class="sc-theme c-flex cursor-pointer">
                                    <div class="name">
                                        <i class="fa fa-plus"></i>
                                        <div class="n-content">Phần 1: Tạo kênh</div>
                                    </div>
                                    <div class="duration total">
                                        3 Bài học - 13 phút
                                    </div>
                                </div>
                                <div class="sc-item c-flex cursor-pointer" v-for="index in 10" @click="openVideo($event, index)" v-bind:class="{'active': index === 2 }">
                                    <div class="name">
                                        <i class="fa fa-play"></i>
                                        <div class="n-content text-line-2">
                                            Bài {{ index }}: Tạo gmail để tạo kênh 
                                        </div>
                                    </div>
                                    <div class="duration total">04:24</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wc-general-information">
                <div class="gi-card">
                    <div class="gic-image">
                        <img src="https://marketing-courses-stg.s3.ap-southeast-1.amazonaws.com/images/1690108921.jpg" alt="">
                    </div>
                    <div class="gic-action">
                        <div class="price-box-theme">
                            <div class="price">
                                <strong>
                                    1.950.000<sup>đ</sup>
                                </strong>
                                <del>
                                    3.950.000<sup>đ</sup>
                                </del>
                            </div>
                            <span class="discount-price">-51%</span>
                        </div>
                        <div class="btn-action">
                            <a href="#" class="btn btn-danger">Đăng ký học</a>
                            <a href="#" class="btn btn-primary">Thêm vào giỏ hàng</a>
                        </div>
                    </div>
                    <div class="gic-info">
                        <div class="gic-info-item">
                            <i class="fa fa-clock"></i>
                            Thời lượng: 
                            <strong>13 phút</strong>
                        </div>
                        <div class="gic-info-item">
                            <i class="fa fa-play"></i>
                            Giáo trình: 
                            <strong>3 bài giảng</strong>
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
    import ThirdBanner from '../../commons/banner/ThirdBanner.vue';

    export default {
        name: 'Course',
        components: {
            ThirdBanner
        },
        data() {
            return {
                canvasData: {
                    ctx: null,
                    videoWidth: 640,
                    videoHeight: 360,
                    canvas: null
                },
                posterImage: null,
                video: null,
                volume: 1.0,
                isFullScreen: false,
            };
        },
        mounted() {
            this.createCanvas();
        },
        methods: {
            createCanvas() {
                this.canvasData.canvas = this.$refs.canvas;
                this.canvasData.ctx = this.canvasData.canvas.getContext('2d');

                this.posterImage = new Image();
                this.posterImage.src = 'https://marketing-courses-stg.s3.ap-southeast-1.amazonaws.com/images/1690109011.jpg';

                this.video = document.createElement('video');
                this.video.$refs = 'video';
                this.video.src = 'https://marketing-courses-stg.s3.ap-southeast-1.amazonaws.com/videos/datg.mp4';

                this.video.addEventListener('loadedmetadata', () => {
                    this.canvasData.canvas.width = this.video.videoWidth;
                    this.canvasData.canvas.height = this.video.videoHeight;
                });

                this.video.onloadedmetadata = () => {
                    this.drawData(this.posterImage);
                    this.drawFrame();
                };
            },

            drawData(value) {
                this.canvasData.ctx.drawImage(value, 0, 0, this.canvasData.canvas.width, this.canvasData.canvas.height);
            },

            drawFrame() {
                this.drawData(this.video);
                requestAnimationFrame(this.drawFrame);
            },

            startVideo(e) {
                e.preventDefault();
                if (this.video.paused) {
                    this.video.play();
                } else {
                    this.video.pause();
                }
                
                this.drawFrame();
            },

            seekVideo(e, value) {
                e.preventDefault();
                const newTime = this.video.currentTime + value;
                this.video.currentTime = Math.min(newTime, this.video.duration);
            },

            changeVolumnVideo(e) {
                e.preventDefault();
                this.video.volume = this.volume;
            },
            
            zoomVideo(e) {
                e.preventDefault();

                const elem = this.$refs.canvas;

                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.webkitRequestFullscreen) {
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen();
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

            openVideo(e, index) {
                e.preventDefault();
                
                console.log('Mở video: ' + index);
            }
        }
    }
</script>
