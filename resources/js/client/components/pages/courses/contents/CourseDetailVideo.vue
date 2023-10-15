<template>
    <div class="box-card">
        <div class="tab-detail pd-tab">
            <h3>Video</h3>
            <div class="text-center" v-if="!videoSrc">Lựa chọn video để xem</div>

            <div class="video" v-else>
                <video controls>
                    <source :src="videoSrc">
                </video>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CourseDetailVideo',
        props: {
            videoSrc: String,
        },
        data() {
            return {

            };
        },
        updated() {
            
        },
        methods: {
            
        }
    }
</script>
