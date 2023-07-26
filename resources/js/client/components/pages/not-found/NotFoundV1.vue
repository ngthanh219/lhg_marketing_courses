<template>
    <div class="content-wrapper">
        <div class="content">
            Trang này không tồn tại
        </div>
    </div>
</template>

<script>
    export default {
        name: 'NotFoundV1'
    }
</script>

<style lang="scss" scoped>
    .content-wrapper {
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