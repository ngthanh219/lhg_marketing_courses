<template>
    <div class="w-content reviewer image-br" :style="{ 'background': 'url(' + $env.s3Url + 'banners/grey-br.jpg)' }">
        <div class="wc-box">
            <div class="box member">
                <img :src="$env.s3Url + 'banners/cam-nhan-hoc-vien.png'" />
                <!-- <div class="slider">
                    <swiper
                        :modules="modules"
                        :slides-per-view="1"
                        :space-between="1"
                        navigation
                        :pagination="{ clickable: true }"
                        @swiper="onSwiper"
                        @slideChange="onSlideChange"
                    >
                        <swiper-slide v-for="index, key in images">
                            <img :src="$env.s3Url + 'reviewers/' + index + '.jpg'">
                        </swiper-slide>
                    </swiper>
                </div> -->
                
                <div class="youtube-video text-center">
                    <iframe width="1250" height="703" src="https://www.youtube.com/embed/d4dzkdh60MY" title="Tổng hợp video phản hồi học viên khi học xong khóa học củaPMT Group" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { Navigation, Pagination, Scrollbar, A11y } from 'swiper/modules';
    import { Swiper, SwiperSlide } from 'swiper/vue';
    import 'swiper/css';
    import 'swiper/css/navigation';
    import 'swiper/css/pagination';
    import 'swiper/css/scrollbar';

    export default {
        name: 'ReviewerContent',
        components: {
            Swiper,
            SwiperSlide,
        },
        setup() {
            const onSwiper = (swiper) => {
            };
            const onSlideChange = () => {
            };
            return {
                onSwiper,
                onSlideChange,
                modules: [Navigation, Pagination, Scrollbar, A11y],
            };
        },
        data() {
            return {
                images: [
                    1,2,3,4,5,6,7,8,9,10,11,12,13,14,15
                ]
            }
        }
    }
</script>
