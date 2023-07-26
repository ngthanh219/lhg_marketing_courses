<template>
    <div class="popup-component" v-bind:class="{ 'transition-active': !isTransitionActive }">
        <div class="pc-form" v-bind:class="{ 'transition-active': isTransitionActive }">
            <div class="content">
                <div class="container-fluid" style="width: 80%">
                    <div class="row" v-if="!isModalList">
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
                                            <label>Thời gian</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.duration">
                                        </div>
                                        <div class="form-group" v-if="videoData != null">
                                            <div class="custom-control custom-checkbox">
                                                <input 
                                                    class="custom-control-input" 
                                                    type="checkbox" 
                                                    id="customCheckbox2" 
                                                    v-model="formData.is_change_video"
                                                >
                                                <label for="customCheckbox2" class="custom-control-label cursor-pointer">Thay video</label>
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="formData.is_change_video">
                                            <label for="exampleInputFile">Video</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="exampleInputFile" @change="handleSource($event)">
                                                    <label class="custom-file-label" for="exampleInputFile">Chọn file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Tải lên</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Mô tả</label>
                                            <textarea class="form-control" rows="10" v-model="formData.description" placeholder="xxx"></textarea>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-2" v-bind:class="{
                                            disabled: !(this.$helper.checkChangeFormData(videoData, formData) || formData.is_change_video)
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
                        v-else

                        :closeModalList="closeModalList"
                        :selectCourseSectionData="selectCourseSectionData"
                        :courseSectionId="formData.course_section_id"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CourseSectionList from './CourseSectionList.vue';

    export default {
        name: "VideoInformation",
        components: {
            CourseSectionList
        },
        props: {
            closeForm: Function,
            getVideoData: Function,
            videoData: Object
        },
        data() {
            return {
                isTransitionActive: false,
                formData: {
                    course_section_id: null,
                    description: '',
                    is_change_video: false,
                    source: '',
                    duration: 0,
                    is_show: 0
                },
                formDataError: {
                    message: '',
                    description: '',
                    is_change_video: '',
                    source: '',
                    duration: 0,
                    is_show: 0
                },
                isModalList: false,
                courseSectionName: null
            }
        },
        mounted() {
            this.$helper.scrollTop()

            setTimeout(() => {
                this.isTransitionActive = true;

                if (this.videoData) {
                    this.$helper.mergeArrayData(this.videoData, this.formData);
                    this.courseSectionName = this.videoData.course_section_name;
                } else {
                    this.formData.is_change_video = true;
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
                    if (this.$helper.checkChangeFormData(this.videoData, this.formData) || this.formData.is_change_video) {
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
                    this.$helper.setNotification(1, 'Tạo mới thành công');
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
                    this.formData.is_change_video = 0;
                    this.videoData.source_url = res.data.source_url;
                    this.$helper.mergeArrayData(this.formData, this.videoData);

                    this.$helper.setNotification(1, 'Cập nhật thành công');
                })
                .catch(err => {

                });
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

            handleSource(e) {
                var self = this;
                const reader = new FileReader();

                reader.readAsDataURL(e.target.files[0]);
                self.formData.source = e.target.files[0];
            }
        }
    }
</script>
