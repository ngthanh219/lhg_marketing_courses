<template>
    <div class="banner"
    :style="
        'background: url(' + $env.storageUrl + 'banner2.png);'
    "
    >
        <div class="overlay"></div>
        <div class="b-content">
            <h2>ĐĂNG KÝ TRỞ THÀNH AFFILIATE</h2>
            <span> Hoa Hồng Từ 30% - 50%</span>
            <a href="#" class="btn btn-danger">Đăng ký ngay</a>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'SecondBanner',
        mounted() {
            
        },
    }
</script>
