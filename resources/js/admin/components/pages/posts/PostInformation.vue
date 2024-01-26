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
                                            {{ postData ? 'Thông tin bài viết' : 'Thêm mới bài viết' }}
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
                                            <label>Tên bài viết</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.name">
                                        </div>
                                        <div class="form-group">
                                            <label>Nội dung</label>
                                            <textarea id="summernote" ref="content" v-model="formData.content"></textarea>
                                        </div>
                                        <div class="form-group" v-if="postData != null">
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
                                        <div class="form-group" v-if="postData != null">
                                            <div class="form-preview-image">
                                                Ảnh hiện tại{{ postData.image_url != null || previewImage != null  ? '' : ': Chưa có' }}

                                                <img class="img-fluid mb-3" v-if="previewImage != null" :src="previewImage" alt="Photo">
                                                <img class="img-fluid mb-3" v-if="previewImage == null && postData.image_url" :src="postData.image_url" alt="Photo">
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="postData == null">
                                            <div class="form-preview-image">
                                                Ảnh hiện tại{{  previewImage ? '' : ': Chưa có' }}

                                                <img class="img-fluid mb-3" v-if="previewImage !== null" :src="previewImage" alt="Photo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <!-- <button type="submit" class="btn btn-primary mr-2" v-bind:class="{
                                            disabled: !(this.$helper.checkChangeFormData(postData, formData) || formData.is_change_image)
                                        }"> -->
                                        <button type="submit" class="btn btn-primary mr-2">
                                            {{ postData ? 'Cập nhật' : 'Thêm mới' }}
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
        name: "PostInformation",
        props: {
            closeForm: Function,
            getPostData: Function,
            postData: Object
        },
        data() {
            return {
                isTransitionActive: false,
                previewImage: null,
                formData: {
                    name: '',
                    content: '',
                    is_change_image: false,
                    image_url: '',
                    is_show: 0
                },
                formDataError: {
                    message: '',
                    name: '',
                    content: '',
                    is_change_image: '',
                    image_url: '',
                    is_show: ''
                }
            }
        },
        mounted() {
            this.$helper.scrollTop();
            var self = this;

            setTimeout(() => {
                this.isTransitionActive = true;

                if (this.postData) {
                    this.$helper.mergeArrayData(this.postData, this.formData);
                } else {
                    this.formData.is_change_image = true;
                }

                const toolbarOptions = [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['color', ['forecolor', 'backcolor']],
                    ['fontsize', ['fontsize']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['link']]
                ];
                $('#summernote').summernote({
                    toolbar: toolbarOptions,
                    toolbarOptions: {
                        fontsize: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48', '60', '72', '96'],
                    },
                    callbacks: {
                        onImageUpload: function(files) {
                            self.$helper.setPageLoading(true);
                            let fileData = {
                                file: files[0],
                                folder: 'images'
                            };

                            self.$store.dispatch("uploadFile", {
                                request: self.$helper.appendFormData(fileData),
                                error: self.formDataError
                            })
                            .then(res => {
                                $('#summernote').summernote('editor.insertImage', res.data);
                                self.$helper.setPageLoading(false);
                            })
                            .catch(err => {
                                self.$helper.setPageLoading(false);
                            });
                        }
                    }
                });
                $('#summernote').summernote('code', this.formData.content);
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

                this.formData.content = $('#summernote').summernote('code');

                if (this.postData) {
                    if (this.$helper.checkChangeFormData(this.postData, this.formData) || this.formData.is_change_image == 1) {
                        this.$helper.setPageLoading(true);
                        await this.update();
                    }
                } else {
                    if (this.$helper.checkChangeFormData(null, this.formData)) {
                        this.$helper.setPageLoading(true);
                        var transaction = await this.create();

                        if (transaction) {
                            await this.getPostData();
                            this.closeFormComponent(e);
                        } else {
                            this.$helper.setPageLoading(false);
                        }
                    }
                }
            },

            async create() {
                var transaction = false;
                await this.$store.dispatch("createPost", {
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
                await this.$store.dispatch("updatePost", {
                    id: this.postData.id,
                    request: this.$helper.appendFormData(this.formData),
                    error: this.formDataError
                })
                .then(res => {
                    this.formData.is_change_image = 0;
                    this.formData.image_url = res.data.image_url;
                    this.formData.price = res.data.price;
                    this.postData.discount_price = res.data.discount_price;
                    this.$helper.mergeArrayData(this.formData, this.postData);

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
                if (this.postData !== null) {
                    if (this.formData.is_change_image) {
                        this.previewImage = null;
                        this.formData.image_url = this.postData.image_url;
                    }
                }
            }
        }
    }
</script>
