<template>
    <div class="w-content">
        <div class="reason-container page">
            <h3>Tại sao bạn nên lựa chọn chúng tôi?</h3>
            <div class="reason-box">
                <div class="rb-item">
                    <div class="image">
                        <img :src="$env.s3Url + 'banners/rs1.png'" alt="">
                    </div>
                    <p>ĐÀO TẠO KINH DOANH SỐ THỰC CHIẾN</p>
                    <span>PMT GROUP không chỉ đào tạo thực chiến từ trải nghiệm thực tế, chúng tôi còn đào tạo chiến lược – chiến thuật cho bạn cái nhìn toàn diện về kinh doanh online thành công</span>
                </div>
                <div class="rb-item">
                    <div class="image">
                        <img :src="$env.s3Url + 'banners/rs2.png'" alt="">
                    </div>
                    <p>CHÚNG TÔI BIẾT CÁC BẠN CẦN GÌ</p>
                    <span>Xuất phát điểm là một doanh nghiệp kinh doanh online nên PMT GROUP biết khách hàng cần gì, chia sẻ trải nghiệm thực tế đánh đổi bằng rất nhiều tiền, công sức, thời gian…vv</span>
                </div>
                <div class="rb-item">
                    <div class="image">
                        <img :src="$env.s3Url + 'banners/rs3.png'" alt="">
                    </div>
                    <p>Thanh toán 1 lần</p>
                    <span>Với kinh nghiệm thực chiến dày dặn & tư duy tốt, các giảng viên của PMT GROUP mang đến cho học viên những kiến thức “Không màu mè – Không hoa mỹ – Chỉ thực tế”</span>
                </div>
                <div class="rb-item">
                    <div class="image">
                        <img :src="$env.s3Url + 'banners/rs4.png'" alt="">
                    </div>
                    <p>GIÁO TRÌNH ĐỔI MỚI – HỖ TRỢ TRỌN ĐỜI</p>
                    <span>Giáo trình đào tạo chuyên sâu của PMT GROUP luôn được cập nhật liên tục, phù hợp xu hướng mới. Học viên được thực hành thành thạo, hỗ trợ trọn đời sau khóa học tận tình và chu đáo</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ReasonContent',
    props: {
        
    },
}
</script>
