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
                                            {{ courseSectionData ? 'Thông tin phần học' : 'Thêm mới phần học' }}
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
                                            <label>Khóa học</label>
                                            <a class="cursor-pointer" @click="openModalList">
                                                Lựa chọn
                                            </a>
                                            <input type="text" class="form-control form-control-border" v-model="courseName" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Tên phần học</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.name">
                                        </div>
                                        <!-- <div class="form-group">
                                            <label>Mô tả</label>
                                            <textarea class="form-control" rows="10" v-model="formData.description" placeholder="xxx"></textarea>
                                        </div> -->
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-2" v-bind:class="{
                                            disabled: !this.$helper.checkChangeFormData(courseSectionData, formData)
                                        }">
                                            {{ courseSectionData ? 'Cập nhật' : 'Thêm mới' }}
                                        </button>
                                        <a class="btn btn-danger" @click="closeFormComponent">Hủy</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <CourseList
                        v-else

                        :closeModalList="closeModalList"
                        :selectCourseData="selectCourseData"
                        :courseId="formData.course_id"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CourseList from './CourseList.vue';

    export default {
        name: "CourseSectionInformation",
        components: {
            CourseList
        },
        props: {
            closeForm: Function,
            getCourseSectionData: Function,
            courseData: Object,
            courseSectionData: Object
        },
        data() {
            return {
                isTransitionActive: false,
                formData: {
                    course_id: null,
                    name: '',
                    description: '',
                    is_show: 0
                },
                formDataError: {
                    message: '',
                    course_id: '',
                    name: '',
                    description: '',
                    is_show: ''
                },
                isModalList: false,
                courseName: null
            }
        },
        mounted() {
            this.$helper.scrollTop()

            setTimeout(() => {
                this.isTransitionActive = true;

                if (this.courseData) {
                    this.formData.course_id = this.courseData.id;
                    this.courseName = this.courseData.name;
                }

                if (this.courseSectionData) {
                    this.$helper.mergeArrayData(this.courseSectionData, this.formData);
                    this.courseName = this.courseSectionData.course_name;
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

                if (this.courseSectionData) {
                    if (this.$helper.checkChangeFormData(this.courseSectionData, this.formData)) {
                        this.$helper.setPageLoading(true);
                        await this.update();

                        if (typeof (this.$helper.getQueryUrl().course_id) !== 'undefined') {
                            if (this.$helper.getQueryUrl().course_id != this.formData.course_id) {
                                await this.getCourseSectionData();
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
                            await this.getCourseSectionData();
                            this.closeFormComponent(e);
                        } else {
                            this.$helper.setPageLoading(false);
                        }
                    }
                }
            },

            async create() {
                var transaction = false;
                await this.$store.dispatch("createCourseSection", {
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
                await this.$store.dispatch("updateCourseSection", {
                    id: this.courseSectionData.id,
                    request: this.$helper.appendFormData(this.formData),
                    error: this.formDataError
                })
                .then(res => {
                    this.$helper.mergeArrayData(this.formData, this.courseSectionData);

                    this.$helper.setNotification(1, 'Cập nhật thành công');
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

            selectCourseData(id, name) {
                this.formData.course_id = id;
                this.courseName = name;
            }
        }
    }
</script>
