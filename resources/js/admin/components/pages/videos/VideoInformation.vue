<template>
    <div class="popup-component" v-bind:class="{ 'transition-active': !isTransitionActive }">
        <div class="pc-form" v-bind:class="{ 'transition-active': isTransitionActive }">
            <div class="content">
                <div class="container-fluid" style="width: 80%">
                    <div class="row" v-if="!isModalList && !isModalVideoObjectList">
                        <div class="col-md-12">
                            <form @submit="handleData">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            {{ videoData ? 'Thông tin video' : 'Thêm mới video' }}
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <select class="form-control" v-model="formData.is_show">
                                                <option value="0">Hiển thị</option>
                                                <option value="1">Ẩn</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Phần học</label>
                                            <a class="cursor-pointer" @click="openModalList">
                                                Lựa chọn
                                            </a>
                                            <input type="text" class="form-control form-control-border" v-model="courseSectionName" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Tên video</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.name">
                                        </div>
                                        <div class="form-group">
                                            <label>Gắn link video</label>
                                            <a class="cursor-pointer" @click="openModalVideoObjectList">
                                                Lựa chọn
                                            </a>
                                            <input type="text" class="form-control form-control-border" v-model="formData.source" disabled>
                                            <span v-if="videoData">Thời gian: <a href="#">{{$helper.formatDuration(formData.duration)}}</a></span>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-2" v-bind:class="{
                                            disabled: !(this.$helper.checkChangeFormData(videoData, formData) || formData.source)
                                        }">
                                            {{ videoData ? 'Cập nhật' : 'Thêm mới' }}
                                        </button>
                                        <a class="btn btn-danger" @click="closeFormComponent">Hủy</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <CourseSectionList
                        v-if="isModalList && !isModalVideoObjectList"

                        :closeModalList="closeModalList"
                        :selectCourseSectionData="selectCourseSectionData"
                        :courseSectionId="formData.course_section_id"
                    />

                    <VideoObjectList
                        v-if="!isModalList && isModalVideoObjectList"

                        :closeModalList="closeModalVideoObjectList"
                        :selectSourceData="selectSourceData"
                        :source="formData.source"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CourseSectionList from './CourseSectionList.vue';
    import VideoObjectList from './VideoObjectList.vue';

    export default {
        name: "VideoInformation",
        components: {
            CourseSectionList,
            VideoObjectList
        },
        props: {
            closeForm: Function,
            getVideoData: Function,
            courseSectionData: Object,
            videoData: Object
        },
        data() {
            return {
                isTransitionActive: false,
                formData: {
                    course_section_id: null,
                    name: '',
                    source: '',
                    duration: 0,
                    is_show: 0
                },
                formDataError: {
                    message: '',
                    course_section_id: '',
                    name: '',
                    source: '',
                    duration: 0,
                    is_show: 0
                },
                isModalList: false,
                isModalVideoObjectList: false,
                courseSectionName: null
            }
        },
        mounted() {
            this.$helper.scrollTop()

            setTimeout(() => {
                this.isTransitionActive = true;

                if (this.courseSectionData) {
                    this.formData.course_section_id = this.courseSectionData.id;
                    this.courseSectionName = this.courseSectionData.name;
                }

                if (this.videoData) {
                    this.$helper.mergeArrayData(this.videoData, this.formData);
                    this.courseSectionName = this.videoData.course_section_name;
                }
            }, 200);
        },
        methods: {
            closeFormComponent(e) {
                e.preventDefault();

                this.isTransitionActive = false;
                setTimeout(() => {
                    this.closeForm(e);
                }, 400);
            },

            async handleData(e) {
                e.preventDefault();

                if (this.videoData) {
                    if (this.$helper.checkChangeFormData(this.videoData, this.formData) || this.formData.source) {
                        this.$helper.setPageLoading(true);
                        await this.update();

                        if (typeof (this.$helper.getQueryUrl().course_section_id) !== 'undefined') {
                            if (this.$helper.getQueryUrl().course_section_id != this.formData.course_section_id) {
                                await this.getVideoData();
                                this.closeFormComponent(e);
                            }
                        } else {
                            this.$helper.setPageLoading(false);
                        }
                    }
                } else {
                    if (this.$helper.checkChangeFormData(null, this.formData)) {
                        this.$helper.setPageLoading(true);
                        var transaction = await this.create();

                        if (transaction) {
                            await this.getVideoData();
                            this.closeFormComponent(e);
                        } else {
                            this.$helper.setPageLoading(false);
                        }
                    }
                }
            },

            async create() {
                var transaction = false;
                await this.$store.dispatch("createVideo", {
                    request: this.$helper.appendFormData(this.formData),
                    error: this.formDataError
                })
                .then(res => {
                    transaction = true;
                    this.$helper.setNotification(1, 'Thông tin đã được tạo');
                })
                .catch(err => {

                });

                return transaction;
            },

            async update() {
                await this.$store.dispatch("updateVideo", {
                    id: this.videoData.id,
                    request: this.$helper.appendFormData(this.formData),
                    error: this.formDataError
                })
                .then(res => {
                    this.formData.duration = parseInt(res.data.duration);
                    this.$helper.mergeArrayData(this.formData, this.videoData);

                    this.$helper.setNotification(1, 'Thông tin đã được cập nhật');
                })
                .catch(err => {

                });
                this.$helper.setPageLoading(false);
            },

            openModalList(e) {
                e.preventDefault();

                this.isModalList = true;
            },

            closeModalList() {
                this.isModalList = false;
            },

            selectCourseSectionData(id, name) {
                this.formData.course_section_id = id;
                this.courseSectionName = name;
            },

            openModalVideoObjectList(e) {
                e.preventDefault();

                this.isModalVideoObjectList = true;
            },

            closeModalVideoObjectList() {
                this.isModalVideoObjectList = false;
            },

            selectSourceData(key, duration) {
                this.formData.source = key;
                this.formData.duration = duration;
            }
        }
    }
</script>
