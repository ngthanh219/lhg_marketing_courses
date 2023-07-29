<template>
    <div class="popup-component" v-bind:class="{ 'transition-active': !isTransitionActive }">
        <div class="pc-form" v-bind:class="{ 'transition-active': isTransitionActive }">
            <div class="content">
                <div class="container-fluid" style="width: 80%">
                    <div class="row">
                        <div class="col-md-12">
                            <form @submit="handleData">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            {{ courseData ? 'Thông tin khóa học' : 'Thêm mới khóa học' }}
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
                                            <label>Tên khóa học</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.name">
                                        </div>
                                        <div class="form-group">
                                            <label>Slogan</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.slogan">
                                        </div>
                                        <div class="form-group">
                                            <label>Giới thiệu</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.introduction">
                                        </div>
                                        <div class="form-group">
                                            <label>Mô tả</label>
                                            <textarea class="form-control" rows="10" v-model="formData.description" placeholder="xxx"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Giá: {{ parseInt(formData.price).toLocaleString() }}đ</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.price" @keypress="this.$helper.isNumber($event)">
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                Khuyến mãi ({{ formData.discount ? formData.discount : 0 }}% = {{ parseInt(formData.price * (formData.discount / 100)).toLocaleString() }}đ) còn:
                                                {{ parseInt(formData.price - (formData.price * (formData.discount / 100))).toLocaleString() }}đ</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.discount" @keypress="this.$helper.isNumber($event)">
                                        </div>
                                        <div class="form-group" v-if="courseData != null">
                                            <div class="custom-control custom-checkbox">
                                                <input 
                                                    class="custom-control-input" 
                                                    type="checkbox" 
                                                    id="customCheckbox2" 
                                                    v-model="formData.is_change_image"
                                                    @click="checkPreviewImage"
                                                >
                                                <label for="customCheckbox2" class="custom-control-label cursor-pointer">Thay ảnh</label>
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="formData.is_change_image">
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
                                        <div class="form-group" v-if="courseData != null">
                                            <div class="form-preview-image">
                                                Ảnh hiện tại{{ courseData.image_url != null || previewImage != null  ? '' : ': Chưa có' }}

                                                <img class="img-fluid mb-3" v-if="previewImage != null" :src="previewImage" alt="Photo">
                                                <img class="img-fluid mb-3" v-if="previewImage == null && courseData.image_url" :src="courseData.image_url" alt="Photo">
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="courseData == null">
                                            <div class="form-preview-image">
                                                Ảnh hiện tại{{  previewImage ? '' : ': Chưa có' }}

                                                <img class="img-fluid mb-3" v-if="previewImage !== null" :src="previewImage" alt="Photo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-2" v-bind:class="{
                                            disabled: !(this.$helper.checkChangeFormData(courseData, formData) || formData.is_change_image)
                                        }">
                                            {{ courseData ? 'Cập nhật' : 'Thêm mới' }}
                                        </button>
                                        <a class="btn btn-danger" @click="closeFormComponent">Hủy</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CourseInformation",
        props: {
            closeForm: Function,
            getCourseData: Function,
            courseData: Object
        },
        data() {
            return {
                isTransitionActive: false,
                previewImage: null,
                formData: {
                    name: '',
                    slogan: '',
                    introduction: '',
                    description: '',
                    is_change_image: false,
                    image_url: '',
                    price: 0,
                    discount: 0,
                    is_show: 0
                },
                formDataError: {
                    message: '',
                    name: '',
                    slogan: '',
                    introduction: '',
                    description: '',
                    is_change_image: '',
                    image_url: '',
                    price: '',
                    discount: '',
                    is_show: ''
                }
            }
        },
        mounted() {
            this.$helper.scrollTop()

            setTimeout(() => {
                this.isTransitionActive = true;

                if (this.courseData) {
                    this.$helper.mergeArrayData(this.courseData, this.formData);
                } else {
                    this.formData.is_change_image = true;
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

                if (this.courseData) {
                    if (this.$helper.checkChangeFormData(this.courseData, this.formData) || this.formData.is_change_image == 1) {
                        this.$helper.setPageLoading(true);
                        await this.update();
                    }
                } else {
                    if (this.$helper.checkChangeFormData(null, this.formData)) {
                        this.$helper.setPageLoading(true);
                        var transaction = await this.create();

                        if (transaction) {
                            await this.getCourseData();
                            this.closeFormComponent(e);
                        } else {
                            this.$helper.setPageLoading(false);
                        }
                    }
                }
            },

            async create() {
                var transaction = false;
                await this.$store.dispatch("createCourse", {
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
                await this.$store.dispatch("updateCourse", {
                    id: this.courseData.id,
                    request: this.$helper.appendFormData(this.formData),
                    error: this.formDataError
                })
                .then(res => {
                    this.formData.is_change_image = 0;
                    this.formData.image_url = res.data.image_url;
                    this.formData.price = res.data.price;
                    this.courseData.discount_price = res.data.discount_price;
                    this.$helper.mergeArrayData(this.formData, this.courseData);

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
                self.formData.image_url = e.target.files[0];
            },

            checkPreviewImage() {
                if (this.courseData !== null) {
                    if (this.formData.is_change_image) {
                        this.previewImage = null;
                        this.formData.image_url = this.courseData.image_url;
                    }
                }
            }
        }
    }
</script>
