<template>
    <div class="banner-information">
        <div class="bi-content page">
            <div class="site-name">{{ directory }}</div>
            <h3>{{ pageName }}</h3>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'MenuBanner1',
        props: {
            directory: String,
            pageName: String
        },
        mounted() {
            
        },
    }
</script>
