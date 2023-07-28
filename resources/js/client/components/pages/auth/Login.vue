<template>
    <div class="page form-page">
        <div class="form-box">
            <div class="card">
                <div class="card-body">
                    <div class="logo">
                        <a href="https://khoahoc.nguyencanh.net">
                            <img src="https://marketing-courses-stg.s3.ap-southeast-1.amazonaws.com/general/logo.png" class="logo-default-site">
                        </a>
                    </div>
                    <form v-on:submit="login">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Email *" name="email" v-model="formData.email">
                            <span class="fas fa-envelope"></span>
                        </div>
                        <div class="error text-danger text-bold text-sm" v-if="formDataError.email">{{formDataError.email}}</div>

                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Mật khẩu *" name="password" v-model="formData.password">
                            <span class="fas fa-lock"></span>
                        </div>
                        <div class="error text-danger text-bold text-sm" v-if="formDataError.password">{{formDataError.password}}</div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-block" v-if="!isLoginClick">Đăng nhập</button>
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
        name: 'User',
        components: {
            BtnLoading
        },
        data() {
            return {
                isLoginClick: false,
                formData: {
                    email: '',
                    password: ''
                },
                formDataError: {
                    message: '',
                    email: '',
                    password: ''
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
            async login(e) {
                e.preventDefault();

                this.isLoginClick = true;
                if (this.isLoginClick) {
                    await this.$store.dispatch('login', {
                        request: this.$helper.appendFormData(this.formData),
                        error: this.formDataError
                    })
                    .then(res => {
                        this.$helper.setAuth(res.data);
                        this.$helper.redirectPage('');
                    })
                    .catch(err => {
                        
                    });

                    this.isLoginClick = false;
                }
            }
        }
    }
</script>
