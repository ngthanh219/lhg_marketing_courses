<template>
    <div class="page form-page">
        <div class="form-box">
            <div class="card">
                <div class="card-body">
                    <div class="logo">
                        <a href="https://khoahoc.nguyencanh.net">
                            <img :src="this.$env.storageUrl + 'logo.png'" class="logo-default-site">
                        </a>
                    </div>
                    <form v-on:submit="register">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Email *" name="email" v-model="formData.email">
                            <span class="fas fa-envelope"></span>
                        </div>
                        <div class="error text-danger text-bold text-sm" v-if="formDataError.email">{{formDataError.email}}</div>

                        <div class="input-group">
                            <input type="text" class="form-control end-text" placeholder="Mã xác thực *" v-model="formData.verification_code" @keypress="this.$helper.isNumber">
                            <span class="fa-text underline">
                                <a class="cursor-pointer oblique" @click="sendVerifyCode" v-if="!isSendVerifyCode">Gửi mã</a>
                            </span>
                        </div>
                        <div class="error text-danger text-bold text-sm" v-if="formDataError.verification_code">{{formDataError.verification_code}}</div>

                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Họ tên *" name="name" v-model="formData.name">
                            <span class="fas fa-user"></span>
                        </div>
                        <div class="error text-danger text-bold text-sm" v-if="formDataError.name">{{formDataError.name}}</div>

                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Số điện thoại *" v-model="formData.phone" @keypress="this.$helper.isNumber">
                            <span class="fas fa-phone"></span>
                        </div>
                        <div class="error text-danger text-bold text-sm" v-if="formDataError.phone">{{formDataError.phone}}</div>

                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Mật khẩu *" name="password" v-model="formData.password">
                            <span class="fas fa-lock"></span>
                        </div>
                        <div class="error text-danger text-bold text-sm" v-if="formDataError.password">{{formDataError.password}}</div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-block" v-if="!isRegisterClick">Đăng ký tài khoản</button>
                            <div class="btn btn-primary btn-block btn-loading disabled" v-else>
                                <div class="loading">
                                    <BtnLoading />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BtnLoading from '../../commons/loading/BtnLoading.vue';

    export default {
        name: 'Register',
        components: {
            BtnLoading
        },
        data() {
            return {
                isSendVerifyCode: false,
                isRegisterClick: false,
                formData: {
                    email: '',
                    password: '',
                    name: '',
                    phone: '',
                    verification_code: '',
                },
                formDataError: {
                    message: '',
                    email: '',
                    password: '',
                    name: '',
                    phone: '',
                    verification_code: '',
                },
            }
        },
        mounted() {
            var auth = this.$store.state.auth;

            if (auth.accessToken && auth.user) {
                this.$helper.redirectPage('');
            }
        },
        methods: {
            async sendVerifyCode(e) {
                e.preventDefault();

                this.isSendVerifyCode = true;
                if (this.isSendVerifyCode) {
                    await this.$store.dispatch('sendVerifyCode', {
                        request: this.$helper.appendFormData(this.formData),
                        error: this.formDataError
                    })
                    .then(res => {
                        this.$helper.setNotification(1, 'Đã gửi mã xác thực về email của bạn');
                    })
                    .catch(err => {
                        
                    });

                    this.isSendVerifyCode = false;
                }
            },

            async register(e) {
                e.preventDefault();

                this.isRegisterClick = true;
                if (this.isRegisterClick) {
                    await this.$store.dispatch('register', {
                        request: this.$helper.appendFormData(this.formData),
                        error: this.formDataError
                    })
                    .then(res => {
                        this.$helper.setNotification(1, 'Đăng ký thành công');
                        this.$helper.redirectPage('dang-nhap');
                    })
                    .catch(err => {
                        
                    });

                    this.isRegisterClick = false;
                }
            },
        }
    }
</script>
