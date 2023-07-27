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
                                <div class="sc-item c-flex cursor-pointer" v-for="index in 10" @click="openVideo($event, index)">
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
        mounted() {
            
        },
        methods: {
            openVideo(e, index) {
                e.preventDefault();
                
                console.log('Mở video: ' + index);
            }
        }
    }
</script>
