<template>
    <div class="wrapper">
        <div class="w-content page">
            <div class="wc-box">
                <div class="title">Tất cả khóa học</div>
                <div class="wc-information">
                    <div class="box-card">
                        <div class="tab-detail">
                            <ul>
                                <li>
                                    <a href="#" class="text-center">Mới nhất</a>
                                </li>
                                <li>
                                    <a href="#" class="text-center">Giá tăng dần</a>
                                </li>
                                <li>
                                    <a href="#" class="text-center">Giá giảm dần</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <CourseContent />
            </div>
        </div>
        <br v-for="index in 16">
    </div>
</template>

<script>
    import CourseContent from '../../commons/content/CourseContent.vue';

    export default {
        name: 'CourseList',
        components: {
            CourseContent
        },
        mounted() {
            
        },
    }
</script>
