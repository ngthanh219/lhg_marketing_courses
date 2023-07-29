<template>
    <div class="popup-component" v-bind:class="{ 'transition-active': !isTransitionActive }">
        <div class="pc-form" v-bind:class="{ 'transition-active': isTransitionActive }">
            <div class="content">
                <div class="container-fluid" style="width: 80%">
                    <div class="row" v-if="!isUserModalList && !isCourseModalList">
                        <div class="col-md-12">
                            <form @submit="handleData">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            {{ courseUserData ? 'Thông tin đăng ký' : 'Thêm mới đăng ký' }}
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Trạng thái hiển thị</label>
                                            <select class="form-control" v-model="formData.is_show">
                                                <option value="0">Hiển thị</option>
                                                <option value="1">Ẩn</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Trạng thái khóa học</label>
                                            <select class="form-control" v-model="formData.status">
                                                <option value="0">Đang sử dụng</option>
                                                <option value="1">Đang chờ xác thực</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Người dùng</label>
                                            <a class="cursor-pointer" @click="openModalList($event, 'user')">
                                                Lựa chọn
                                            </a>
                                            <input type="text" class="form-control form-control-border" v-model="userEmail" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Khóa học</label>
                                            <a class="cursor-pointer" @click="openModalList($event, 'course')">
                                                Lựa chọn
                                            </a>
                                            <input type="text" class="form-control form-control-border" v-model="courseName" disabled>
                                        </div>
                                        <div class="form-group" v-if="courseUserData != null">
                                            <div class="custom-control custom-checkbox">
                                                <input 
                                                    class="custom-control-input" 
                                                    type="checkbox" 
                                                    id="customCheckbox2" 
                                                    v-model="formData.is_change_billing_image"
                                                    @click="checkPreviewImage"
                                                >
                                                <label for="customCheckbox2" class="custom-control-label cursor-pointer">Thay ảnh</label>
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="formData.is_change_billing_image">
                                            <label for="exampleInputFile">Ảnh</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="exampleInputFile" @change="handlePreviewImage($event)">
                                                    <label class="custom-file-label" for="exampleInputFile">Chọn file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Tải lên</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="courseUserData !== null">
                                            <div class="form-preview-image" style="height: 300px;">
                                                Ảnh hiện tại{{ courseUserData.billing_image_url != null || previewImage ? '' : ': Chưa có' }}

                                                <img style="height: 100%;" class="img-fluid mb-3" v-if="previewImage != null" :src="previewImage" alt="Photo">
                                                <img style="height: 100%;" class="img-fluid mb-3" v-if="!previewImage && courseUserData.billing_image_url" :src="courseUserData.billing_image_url" alt="Photo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-2" v-bind:class="{
                                            disabled: !(this.$helper.checkChangeFormData(courseUserData, formData) || formData.is_change_billing_image)
                                        }">
                                            {{ courseUserData ? 'Cập nhật' : 'Thêm mới' }}
                                        </button>
                                        <a class="btn btn-danger" @click="closeFormComponent">Hủy</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <UserList
                        v-if="isUserModalList && !isCourseModalList"

                        :closeModalList="closeModalList"
                        :selectUserData="selectUserData"
                        :userId="formData.user_id"
                    />

                    <CourseList
                        v-if="!isUserModalList && isCourseModalList"

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
    import UserList from './UserList.vue';
    import CourseList from './CourseList.vue';

    export default {
        name: "CourseInformation",
        components: {
            UserList,
            CourseList
        },
        props: {
            closeForm: Function,
            getCourseUserData: Function,
            courseUserData: Object
        },
        data() {
            return {
                isTransitionActive: false,
                previewImage: null,
                formData: {
                    user_id: null,
                    course_id: null,
                    is_change_billing_image: false,
                    billing_image_url: '',
                    status: 1,
                    is_show: 0
                },
                formDataError: {
                    message: '',
                    user_id: '',
                    course_id: '',
                    is_change_billing_image: '',
                    billing_image_url: '',
                    status: '',
                    is_show: ''
                },
                userEmail: null,
                courseName: null,
                isUserModalList: false,
                isCourseModalList: false,
            }
        },
        mounted() {
            this.$helper.scrollTop()

            setTimeout(() => {
                this.isTransitionActive = true;

                if (this.courseUserData) {
                    this.$helper.mergeArrayData(this.courseUserData, this.formData);
                    this.userEmail = this.courseUserData.user_email;
                    this.courseName = this.courseUserData.course_name;
                } else {
                    this.formData.is_change_billing_image = true;
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

                if (this.courseUserData) {
                    if (this.$helper.checkChangeFormData(this.courseUserData, this.formData) || this.formData.is_change_billing_image == 1) {
                        this.$helper.setPageLoading(true);
                        await this.update();
                    }
                } else {
                    if (this.$helper.checkChangeFormData(null, this.formData)) {
                        this.$helper.setPageLoading(true);
                        var transaction = await this.create();

                        if (transaction) {
                            await this.getCourseUserData();
                            this.closeFormComponent(e);
                        } else {
                            this.$helper.setPageLoading(false);
                        }
                    }
                }
            },

            async create() {
                var transaction = false;
                await this.$store.dispatch("createCourseUser", {
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
                await this.$store.dispatch("updateCourseUser", {
                    id: this.courseUserData.id,
                    request: this.$helper.appendFormData(this.formData),
                    error: this.formDataError
                })
                .then(res => {
                    this.formData.is_change_billing_image = 0;
                    this.formData.billing_image_url = res.data.billing_image_url;
                    this.$helper.mergeArrayData(this.formData, this.courseUserData);

                    this.$helper.setNotification(1, 'Cập nhật thành công');
                })
                .catch(err => {

                });
                this.$helper.setPageLoading(false);
            },

            handlePreviewImage(e) {
                var self = this;
                const reader = new FileReader();

                reader.onload = (load) => {
                    self.previewImage = load.target.result;
                }

                reader.readAsDataURL(e.target.files[0]);
                self.formData.billing_image_url = e.target.files[0];
            },

            checkPreviewImage() {
                if (this.courseUserData !== null) {
                    if (this.formData.is_change_billing_image) {
                        this.previewImage = null;
                        this.formData.billing_image_url = this.courseUserData.billing_image_url;
                    }
                }
            },

            openModalList(e, type) {
                e.preventDefault();

                if (type === 'user') {
                    this.isUserModalList = true;
                } else {
                    this.isCourseModalList = true;
                }
            },

            closeModalList(type) {
                if (type === 'user') {
                    this.isUserModalList = false;
                } else {
                    this.isCourseModalList = false;
                }
            },

            selectCourseData(id, name) {
                this.formData.course_id = id;
                this.courseName = name;
            },

            selectUserData(id, email) {
                this.formData.user_id = id;
                this.userEmail = email;
            }
        }
    }
</script>
