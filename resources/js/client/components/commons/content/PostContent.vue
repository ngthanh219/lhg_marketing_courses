<template>
    <div class="w-content page">
        <div class="wc-box">
            <div class="title">Bài viết nổi bật</div>
            <div class="card-list">
                <div class="card-item" v-for="index in 10">
                    <a href="#">
                        <div class="c-image">
                            <img src="https://haycafe.vn/wp-content/uploads/2022/03/hinh-nen-sach-dep-y-nghia.jpg" alt="">
                        </div>
                        <div class="c-info">
                            <div class="theme text-line-3">CÁCH XÂY DỰNG WEBSITE GIÁO DỤC CHUYÊN NGHIỆP VÔ CÙNG ĐƠN GIẢN CÁCH XÂY DỰNG WEBSITE GIÁO DỤC CHUYÊN NGHIỆP VÔ CÙNG ĐƠN GIẢN</div>
                            <div class="detail">
                                <div class="decription text-line-2">
                                    Bạn đang tìm hiểu về cách áp dụng mô hình ADDIE trong quá trình dạy học và đào tạo? Hãy khám phá bài
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'PostContent',
        mounted() {
            
        },
    }
</script>
