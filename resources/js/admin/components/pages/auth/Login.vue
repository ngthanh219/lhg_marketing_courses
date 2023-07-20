<template>
    <body class="login-page">
        <div class="login-box">
            <div class="login-logo">
                <a><b>Quản trị</b></a>
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Đăng nhập để bắt đầu</p>
                    <form v-on:submit="login">
                        <div class="error text-danger text-bold text-sm" v-if="formDataError.message">{{formDataError.message}}</div>
                        <div class="input-group mt-3">
                            <input type="email" class="form-control" placeholder="Email" name="email" v-model="formData.email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="error text-danger text-bold text-sm" v-if="formDataError.email">{{formDataError.email}}</div>
                        <div class="input-group mt-3">
                            <input type="password" class="form-control" placeholder="Mật khẩu" name="password" v-model="formData.password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="error text-danger text-bold text-sm" v-if="formDataError.password">{{formDataError.password}}</div>
                        <div class="row text-center mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" v-if="!isLoginClick">Đăng nhập</button>
                                <div class="btn btn-primary btn-block btn-loading disabled" v-else>
                                    <div class="loading">
                                        <BtnLoading />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
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
                    email: 'admin@gmail.com',
                    password: '123456'
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
                this.$router.push({path: '/admin/users' });
            }
        },
        methods: {
            login(e) {
                e.preventDefault();

                this.isLoginClick = true;
                if (this.isLoginClick) {
                    this.$store.dispatch('login', {
                        request: this.$helper.appendFormData(this.formData),
                        error: this.formDataError
                    })
                    .then(res => {
                        this.$store.commit('setAuth', {
                            user: res.data.user,
                            accessToken: res.data.access_token
                        });
                        this.isLoginClick = false;
                        this.$router.push({path: '/admin/users' });
                    })
                    .catch(err => {
                        this.isLoginClick = false;
                    });
                }
            }
        }
    }
</script>
