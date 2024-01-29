<template>
    <div class="wrapper">
        <FirstBanner />

        <ReasonContent />

        <div class="w-content image-br" :style="{ 'background': 'url(' + $env.s3Url + 'banners/red-br.jpg)' }">
            <div class="wc-box page">
                <img :src="$env.s3Url + 'banners/khoa-hoc.png'" />
                <CourseContent />

                <div class="action flex-center">
                    <router-link to="/khoa-hoc" class="btn btn-primary">Xem thêm</router-link>
                </div>
            </div>
        </div>

        <!-- <div class="bar-clear"><div class="dash"></div></div> -->

        <div class="w-content image-br" :style="{ 'background': 'url(' + $env.s3Url + 'banners/red-br.jpg)' }">
            <div class="wc-box page">
                <img :src="$env.s3Url + 'banners/giao-trinh-pmt.png'" />
                <BookContent />
            </div>
        </div>

        <MemberContent />

        <ReviewerContent />

        <ContactContent/>

        <div class="w-content image-br" :style="{ 'background': 'url(' + $env.s3Url + 'banners/grey-br.jpg)' }">
            <div class="wc-box page">
                <img :src="$env.s3Url + 'banners/bai-viet-noi-bat.png'" />
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
