<template>
    <div class="wrapper grey-br" v-if="$store.state.auth.accessToken != null">
        <MenuBanner
            :pageName="'Đăng ký khóa học'"
        />
        
        <div class="w-content c-detail page">
            <div class="wc-information mg-0">
                <div class="box-card">
                    <div class="tab-detail pd-tab">
                        <h3>Phương thức thanh toán</h3>
                        <div class="form-information pay">
                            <div class="description">
                                Thanh toán bằng phương thức chuyển khoản hoặc quét mã QR
                            </div>
                            <div class="image">
                                <img src="https://marketing-courses-stg.s3.ap-southeast-1.amazonaws.com/images/qr.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-card">
                    <div class="tab-detail pd-tab">
                        <h3>Thông tin liên hệ</h3>
                        <div class="form-information">
                            <form @submit="register">
                                <div class="input-group">
                                    <label for="">Họ tên *</label>
                                    <input type="name" class="form-control" placeholder="Họ tên *" v-model="$store.state.auth.user.name" disabled>
                                </div>
                                <div class="input-group">
                                    <label for="">Email *</label>
                                    <input type="email" class="form-control" placeholder="Email *" name="email" v-model="$store.state.auth.user.email" disabled>
                                </div>
                                <div class="input-group">
                                    <label for="">Số điện thoại *</label>
                                    <input type="text" class="form-control" placeholder="Số điện thoại *" @keypress="this.$helper.isNumber" v-model="$store.state.auth.user.phone" disabled>
                                </div>
                                <div class="input-group custom-file-input">
                                    Chọn ảnh xác nhận đã thanh toán
                                    <input type="file" class="form-control" placeholder="Ảnh thanh toán" @change="handlePreviewImage($event)">
                                </div>
                                <div class="form-group" v-if="formData.billing_image_url">
                                    <button @click="cancelImage" class="btn btn-danger">Xóa ảnh</button>
                                    <div class="form-preview-image">
                                        <img class="img-fluid mb-3" :src="previewImage" alt="Photo">
                                    </div>
                                </div>
                                <div class="input-group ">
                                    <label for="">Ghi chú thêm</label>
                                    <textarea class="form-control" placeholder="Ghi chú thêm" v-model="formData.description"></textarea>
                                </div>
                                <div class="input-group">
                                    <button type="submit" class="btn btn-danger btn-block" v-if="!isRegisterClick">Đăng ký khóa học ngay</button>
                                    <div class="btn btn-danger btn-block btn-loading disabled" v-else>
                                        <div class="loading">
                                            <BtnLoading />
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="fi-description wc-general-information">
                                <div class="gi-card">
                                    <div class="gic-info">
                                        <h3>Thông tin khóa học</h3>
                                        <div class="gic-info-item">
                                            <i class="fa fa-book"></i>
                                            Tên khóa học: <strong>Tạo kênh youtube chuẩn & thiết kế canva</strong>
                                        </div>
                                        <div class="gic-info-item">
                                            <i class="fa fa-shopping-cart"></i>
                                            Giá đăng ký: 
                                            <strong> 1.950.000<sup>đ</sup></strong>
                                        </div>
                                        <div class="gic-info-item">
                                            <i class="fa fa-clock"></i>
                                            Thời lượng: 
                                            <strong>13 phút</strong>
                                        </div>
                                        <div class="gic-info-item">
                                            <i class="fa fa-play"></i>
                                            Giáo trình: 
                                            <strong>3 bài giảng</strong>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MenuBanner from '../../commons/banner/MenuBanner.vue';
    import BtnLoading from '../../commons/loading/BtnLoading.vue';

    export default {
        name: 'RegisterCourse',
        components: {
            MenuBanner,
            BtnLoading
        },
        data() {
            return {
                isRegisterClick: false,
                previewImage: null,
                formData: {
                    course_slug: '',
                    description: '',
                    billing_image_url: ''
                },
                formDataError: {
                    message: '',
                    description: '',
                    billing_image_url: ''
                },
            }
        },
        mounted() {
            if (this.$store.state.auth.accessToken == null) {
                this.$helper.redirectPage('dang-nhap');
            }

            this.formData.course_slug = this.$route.params.courseSlug;
        },
        methods: {
            async register(e) {
                e.preventDefault();

                this.isRegisterClick = true;
                if (this.isRegisterClick) {
                    await this.$store.dispatch('registerCourse', {
                        request: this.$helper.appendFormData(this.formData),
                        error: this.formDataError
                    })
                    .then(res => {
                        this.formData.billing_image_url = '';
                        this.formData.description = '';
                        this.previewImage = null;
                        this.$helper.setNotification(1, 'Chúng tôi đã nhận được thông tin đăng ký khóa học của bạn và sẽ liên lạc với bạn sớm nhất')
                    })
                    .catch(err => {
                        
                    });

                    this.isRegisterClick = false;
                }
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

            cancelImage(e) {
                e.preventDefault();
                this.formData.billing_image_url = null;
                this.previewImage = null;
            }
        }
    }
</script>
