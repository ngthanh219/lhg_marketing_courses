<template>
    <div class="wrapper">
        <FirstBanner />

        <!-- <div class="slogan">
            Học chiến lược tư duy & công cụ marketing giúp bạn 10x thu nhập
        </div> -->

        <ReasonContent />

        <div class="w-content page">
            <div class="wc-box">
                <div class="title">Khóa học</div>
                <CourseContent />

                <div class="action flex-center">
                    <router-link to="/khoa-hoc" class="btn btn-primary">Xem thêm</router-link>
                </div>
            </div>
        </div>

        <div class="bar-clear"><div class="dash"></div></div>

        <div class="w-content page">
            <div class="wc-box">
                <div class="title">Sách</div>
                <BookContent />

                <!-- <div class="action flex-center">
                    <router-link to="/sach" class="btn btn-primary">Xem thêm</router-link>
                </div> -->
            </div>
        </div>

        <div class="bar-clear"><div class="dash"></div></div>

        <MemberContent />

        <div class="bar-clear"><div class="dash"></div></div>

        <ReviewerContent />

        <ContactContent/>

        <div class="w-content" style="
            background-image: url(https://kdtc.s3.ap-southeast-1.amazonaws.com/banners/section7.jpg);
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            padding-top: 300px;
            padding-bottom: 100px;
        ">
            <div class="wc-box">
                <!-- <div class="title">Bài viết nổi bật</div> -->
                <PostContent />

                <div class="action flex-center">
                    <router-link to="/bai-viet" class="btn btn-primary">Xem thêm</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FirstBanner from '../commons/banner/FirstBanner.vue';
    import CourseContent from '../commons/content/CourseContent.vue';
    import PostContent from '../commons/content/PostContent.vue';
    import BookContent from '../commons/content/BookContent.vue';
    import ContactContent from '../commons/content/ContactContent.vue';
    import MemberContent from '../commons/content/MemberContent.vue';
    import CustomerContent from '../commons/content/CustomerContent.vue';
    import ReasonContent from '../commons/content/ReasonContent.vue';
    import ReviewerContent from '../commons/content/ReviewerContent.vue';

    export default {
        name: 'Home',
        components: {
            FirstBanner,
            CourseContent,
            PostContent,
            BookContent,
            ContactContent,
            MemberContent,
            CustomerContent,
            ReasonContent,
            ReviewerContent
        },
        mounted() {
            
        }
    }
</script>
