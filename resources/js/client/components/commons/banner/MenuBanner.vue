<template>
    <div class="banner-information">
        <div class="bi-content page">
            <div class="site-name">Trang chủ / {{ pageName }}</div>
            <h3>{{ pageName }}</h3>
            <div class="bi-slogan">{{ slogan }}</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'MenuBanner',
        props: {
            pageName: String,
            slogan: String
        },
        mounted() {
            
        },
    }
</script>
