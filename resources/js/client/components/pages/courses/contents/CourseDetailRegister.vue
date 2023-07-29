<template>
    <div class="wc-general-information">
        <div class="gi-card">
            <div class="gic-image">
                <img :src="courseDetailData.course.image_url" alt="">
            </div>
            <div class="gic-action">
                <div class="price-box-theme">
                    <div class="price">
                        <strong>
                            {{ courseDetailData.course.discount != 0 ? courseDetailData.course.discount_price.toLocaleString() : courseDetailData.course.price.toLocaleString() }}<sup>đ</sup>
                        </strong>
                        <del v-if="courseDetailData.course.discount != 0">
                            {{ courseDetailData.course.price.toLocaleString() }}<sup>đ</sup>
                        </del>
                    </div>
                    <span class="discount-price">-{{ courseDetailData.course.discount }}%</span>
                </div>
                <div class="btn-action">
                    <router-link :to="this.courseDetailData.course.slug + '/dang-ky'" class="btn btn-danger" v-if="courseDetailData.course.my_course == 2">Đăng ký học</router-link>
                    <div 
                        v-else
                        class="btn"
                        v-bind:class="[
                            courseDetailData.course.my_course == 1 ? 'btn-danger' : 'btn-primary'
                        ]"
                    >
                        {{ courseDetailData.course.my_course == 1 ? 'Đang chờ xác nhận' : 'Đang sở hữu' }}
                    </div>
                </div>
            </div>
            <div class="gic-info">
                <div class="gic-info-item">
                    <i class="fa fa-clock"></i>
                    Thời lượng: 
                    <strong>{{ this.$helper.formatDuration(courseDetailData.total_video_duration) }}</strong>
                </div>
                <div class="gic-info-item">
                    <i class="fa fa-play"></i>
                    Giáo trình: 
                    <strong>{{ courseDetailData.total_course_section }} bài giảng</strong>
                </div>
                <div class="gic-info-item">
                    <i class="fa fa-globe"></i>
                    Học mọi lúc mọi nơi
                </div>
                <div class="gic-info-item">
                    <i class="fa fa-mobile-alt"></i>
                    Học trên mọi thiết bị 
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CourseDetailRegister',
        props: {
            courseDetailData: Object
        },
        data() {
            return {

            }
        },
        mounted() {
            
        },
        methods: {
        }
    }
</script>
