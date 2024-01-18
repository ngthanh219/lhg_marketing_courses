<template>
    <div class="w-content" style="padding: 0">
        <div class="wc-box">
            <div class="box member">
                <img :src="$env.s3Url + 'banners/section4.jpg'" alt="" />
                <img style="margin-top: -10px" :src="$env.s3Url + 'banners/section5.jpg'" alt="" />
                <img style="margin-top: -10px" :src="$env.s3Url + 'banners/section6.jpg'" alt="" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'MemberContent',
    props: {
        
    },
}
</script>
