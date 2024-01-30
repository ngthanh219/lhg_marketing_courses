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
                                            {{ bookData ? 'Thông tin sách' : 'Thêm mới sách' }}
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
                                            <label>Tên sách</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.name">
                                        </div>
                                        <div class="form-group">
                                            <label>Mô tả ngắn</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.introduction">
                                        </div>
                                        <div class="form-group">
                                            <label>Mô tả</label>
                                            <textarea id="summernote" ref="description" v-model="formData.description"></textarea>
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
                                        <div class="form-group">
                                            <label for="exampleInputFile">Ảnh</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="exampleInputFile" @change="handlePreviewImage($event)" accept="image/*" multiple>
                                                    <label class="custom-file-label" for="exampleInputFile">Chọn file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="previewImage.length > 0">
                                            <div class="form-preview-image gallery-image">
                                                <div class="gallery-image-item" v-for="image, index in previewImage">
                                                    <img class="img-fluid mb-3" :src="image.url" alt="Photo">
                                                    <a @click="removeImages($event, image, index)" class="gi-tool cursor-pointer">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-2">
                                            {{ bookData ? 'Cập nhật' : 'Thêm mới' }}
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
        name: "BookInformation",
        props: {
            closeForm: Function,
            getBookData: Function,
            bookData: Object
        },
        data() {
            return {
                isTransitionActive: false,
                formData: {
                    name: '',
                    introduction: '',
                    description: '',
                    price: 0,
                    discount: 0,
                    is_show: 0,
                    image: [],
                    remove_image: []
                },
                formDataError: {
                    message: '',
                    name: '',
                    introduction: '',
                    description: '',
                    price: '',
                    discount: '',
                    is_show: '',
                    image: ''
                },
                previewImage: []    // type: 0 - preview; 1 - live, url
            }
        },
        mounted() {
            this.$helper.scrollTop();
            var self = this;

            setTimeout(() => {
                this.isTransitionActive = true;

                if (this.bookData) {
                    this.$helper.mergeArrayData(this.bookData, this.formData);
                    var imageData = this.formData.image;
                    this.formData.image = [];

                    for (const image in imageData) {
                        this.previewImage.push({
                            type: 1,
                            name: null,
                            url: imageData[image]
                        });
                    }
                }

                const toolbarOptions = [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['color', ['forecolor', 'backcolor']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ];
                $('#summernote').summernote({
                    toolbar: toolbarOptions,
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
                $('#summernote').summernote('code', this.formData.description);
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

                this.formData.description = $('#summernote').summernote('code');

                if (this.bookData) {
                    if (this.$helper.checkChangeFormData(this.bookData, this.formData)) {
                        this.$helper.setPageLoading(true);
                        var transaction = await this.update();

                        if (transaction) {
                            await this.getBookData();
                            // this.closeFormComponent(e);
                        } else {
                            this.$helper.setPageLoading(false);
                        }
                    }
                } else {
                    if (this.$helper.checkChangeFormData(null, this.formData)) {
                        this.$helper.setPageLoading(true);
                        var transaction = await this.create();

                        if (transaction) {
                            await this.getBookData();
                            this.closeFormComponent(e);
                        } else {
                            this.$helper.setPageLoading(false);
                        }
                    }
                }
            },

            async create() {
                var transaction = false;
                await this.$store.dispatch("createBook", {
                    request: this.handleFormRequest(),
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
                var transaction = false;
                await this.$store.dispatch("updateBook", {
                    id: this.bookData.id,
                    request: this.handleFormRequest(),
                    error: this.formDataError
                })
                .then(res => {
                    this.formData.price = res.data.price;
                    this.bookData.discount_price = res.data.discount_price;
                    this.previewImage = [];

                    for (const imageData in res.data.image) {
                        this.previewImage.push({
                            type: 1,
                            name: null,
                            url: res.data.image[imageData]
                        });
                    }

                    this.formData.image = [];
                    this.$helper.mergeArrayData(this.formData, this.bookData);
                    transaction = true;

                    this.$helper.setNotification(1, 'Cập nhật thành công');
                })
                .catch(err => {

                });
                
                return transaction;
            },

            handleFormRequest() {
                const formRequest = new FormData();
                
                for (var param in this.formData) {
                    if (param == 'image' || param == 'remove_image') {
                        for (let i = 0; i < this.formData[param].length; i++) {
                            formRequest.append(param + '[]', this.formData[param][i]);
                        }
                    } else if (this.formData[param] !== null && this.formData[param] !== '') {
                        formRequest.append(param, this.formData[param]);
                    }
                }

                return formRequest;
            },

            handlePreviewImage(e) {
                var self = this;

                for (const file of e.target.files) {
                    const reader = new FileReader();

                    reader.onload = (load) => {
                        self.previewImage.push({
                            type: 0,
                            name: file.name,
                            url: load.target.result
                        });
                    }

                    reader.readAsDataURL(file);
                    self.formData.image.push(file);
                }
            },

            removeImages(e, image, index) {
                e.preventDefault();

                if (this.bookData && this.previewImage.length == 1) {
                    this.$helper.setNotification(0, 'Trường ảnh không được bỏ trống.');
                } else {
                    if (image.type == 0) {
                        this.previewImage.splice(index, 1);
                        this.formData.image = this.formData.image.filter(file => file.name !== image.name);
                    } else {
                        this.formData.remove_image.push(image.url);
                        this.previewImage.splice(index, 1);
                    }
                }
            }
        }
    }
</script>
