<template>
    <div class="banner-image">
        <img :src="$env.s3Url + 'banners/banner.png'">
    </div>
</template>

<script>
    export default {
        name: 'FirstBanner',
        mounted() {
            // <div class="banner"
            //     v-bind:style="
            //         'background: url(' + $env.s3Url + 'banners/banner.png);'
            //     "
            // >
            //     <div class="overlay"></div>
            //     <div class="b-content">
            //         <h2>NGUYỄN CẢNH CHUYÊN GIA MARKETING ĐA KÊNH</h2>
            //         <span>Lớp Học Online 3 Ngày Qua Zoom</span>
            //         <a href="#" class="btn btn-danger">Nhận vé miễn phí</a>
            //     </div>
            // </div>
        },
    }
</script>
