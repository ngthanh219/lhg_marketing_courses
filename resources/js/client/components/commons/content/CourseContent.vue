<template>
    <div class="w-content page">
        <div class="wc-box">
            <div class="title">Tất cả khóa học</div>
            <div class="card-list">
                <div class="card-item" v-for="index in 10">
                    <router-link to="/hoc-tiktok-tao-video">
                        <div class="c-image">
                            <img src="https://marketing-courses-stg.s3.ap-southeast-1.amazonaws.com/images/1690108921.jpg" alt="">
                        </div>
                        <div class="c-info">
                            <div class="theme text-line-2">Tạo kênh tiktok & edit chuyên nghiệp</div>
                            <div class="detail">
                                <div class="lecture">
                                    <div class="name">Nguyễn Thành</div>
                                    <div class="rate">
                                        <i class="fas fa-fw fa-star" v-for="index in 5"></i> (6)
                                    </div>
                                </div>
                                <div class="price">
                                    <span class="old">3.945.000đ</span>
                                    <span class="discount">1.945.000đ</span>
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CourseContent',
        mounted() {
            
        },
    }
</script>
