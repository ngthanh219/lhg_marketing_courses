<template>
    <div class="wrapper">
        <FirstBanner />

        <div class="slogan">
            Học chiến lược tư duy & công cụ marketing giúp bạn 10x thu nhập
        </div>

        <div class="reason">
            <div class="reason-container page">
                <h3>Tại sao bạn nên lựa chọn chúng tôi?</h3>
                <div class="reason-box">
                    <div class="rb-item">
                        <div class="image">
                            <img src="https://edubit.vn/views/themes/default/img/rs1.png" alt="">
                        </div>
                        <p>Học mọi lúc mọi nơi</p>
                        <span>Chỉ cần có điện thoại máy tính bảng, laptop hoặc TV kết nối internet</span>
                    </div>
                    <div class="rb-item">
                        <div class="image">
                            <img src="https://edubit.vn/views/themes/default/img/rs2.png" alt="">
                        </div>
                        <p>Chất lượng</p>
                        <span>Khóa học chất lượng, cập nhật liên tục, nhu cầu cao, dễ chia sẻ</span>
                    </div>
                    <div class="rb-item">
                        <div class="image">
                            <img src="https://edubit.vn/views/themes/default/img/rs3.png" alt="">
                        </div>
                        <p>Thanh toán 1 lần</p>
                        <span>Thanh toán 1 lần, học tất cả các khóa học</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="w-content page">
            <div class="wc-box">
                <div class="title">Tất cả khóa học</div>
                <CourseContent />
            </div>
        </div>

        <SecondBanner />

        <div class="reason">
            <div class="reason-container page">
                <h3>Học viên nói về chúng tôi?</h3>
                <div class="reason-box">
                    <div class="rb-item">
                        <div class="image">
                            <img src="https://edubit.vn/views/themes/default/img/hv1.jpg" alt="">
                        </div>
                        <p>Trần Thị Ngọc Hoa</p>
                        <span>
                            “Thầy dạy rất dễ hiểu áp dụng được ngay vào công việc kinh doanh ...!!! Rất tận tâm và lấy ví dụ hàng ngày vào bài giảng ...!!!”
                        </span>
                    </div>
                    <div class="rb-item">
                        <div class="image">
                            <img src="https://edubit.vn/views/themes/default/img/hv1.jpg" alt="">
                        </div>
                        <p>Trần Thị Ngọc Hoa</p>
                        <span>
                            “Thầy dạy rất dễ hiểu áp dụng được ngay vào công việc kinh doanh ...!!! Rất tận tâm và lấy ví dụ hàng ngày vào bài giảng ...!!!”
                        </span>
                    </div>
                    <div class="rb-item">
                        <div class="image">
                            <img src="https://edubit.vn/views/themes/default/img/hv1.jpg" alt="">
                        </div>
                        <p>Trần Thị Ngọc Hoa</p>
                        <span>
                            “Thầy dạy rất dễ hiểu áp dụng được ngay vào công việc kinh doanh ...!!! Rất tận tâm và lấy ví dụ hàng ngày vào bài giảng ...!!!”
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <PostContent />
    </div>
</template>

<script>
    import FirstBanner from '../commons/banner/FirstBanner.vue';
    import SecondBanner from '../commons/banner/SecondBanner.vue';
    import CourseContent from '../commons/content/CourseContent.vue';
    import PostContent from '../commons/content/PostContent.vue';

    export default {
        name: 'Home',
        components: {
            FirstBanner,
            SecondBanner,
            CourseContent,
            PostContent
        },
        mounted() {
            
        },
    }
</script>
