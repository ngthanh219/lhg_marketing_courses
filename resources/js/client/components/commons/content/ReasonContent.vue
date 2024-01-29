<template>
    <div class="w-content" style="padding: 0">
        <div class="reason-container">
            <img :src="$env.s3Url + 'banners/section1.jpg'" alt="" />
        </div>
    </div>
</template>

<script>
    export default {
        name: "ReasonContent",
        props: {},
    };
</script>
