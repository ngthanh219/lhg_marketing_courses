<template>
    <div class="not-found-v1 wrapper-content">
        <div class="content">
            This page doesn't exist!
        </div>
    </div>
</template>

<script>
    export default {
        name: 'NotFoundV1'
    }
</script>

<style lang="scss" scoped>
    .not-found-v1.wrapper-content {
        display: flex;
        flex: 1;
        justify-content: center;
        align-items: center;
        height: 75vh;

        .content {
            font-size: 35px;
            color: red;
            text-align: center;
        }
    }
</style>