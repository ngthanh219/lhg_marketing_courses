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
                        <div class="error text-danger text-bold text-sm text-center" v-if="formDataError.message">{{formDataError.message}}</div>
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
                    email: 'admin1@gmail.com',
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
                // this.$helper.redirectPage('users');
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
                        this.$helper.redirectPage('users');
                    })
                    .catch(err => {
                        
                    });

                    this.isLoginClick = false;
                }
            }
        }
    }
</script>

<style lang="scss">
    .login-page {
        -ms-flex-align: center;
        align-items: center;
        background-color: #e9ecef;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        height: 100vh;
        -ms-flex-pack: center;
        justify-content: center;

        .login-box {
            width: 360px;

            .login-logo {
                font-size: 2.1rem;
                font-weight: 300;
                margin-bottom: 0.9rem;
                text-align: center;
            }

            .card {
                position: relative;
                display: -ms-flexbox;
                display: flex;
                -ms-flex-direction: column;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-color: #fff;
                background-clip: border-box;
                border: 0 solid rgba(0,0,0,.125);
                border-radius: 0.25rem;
                box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
                margin-bottom: 0;

                .card-body {
                    background-color: #fff;
                    border-top: 0;
                    color: #666;
                    padding: 20px;

                    .login-box-msg {
                        margin: 0;
                        padding: 0 20px 20px;
                        text-align: center;
                    }

                    .input-group {
                        position: relative;
                        display: -ms-flexbox;
                        display: flex;
                        -ms-flex-wrap: wrap;
                        flex-wrap: wrap;
                        -ms-flex-align: stretch;
                        align-items: stretch;
                        width: 100%;
                        margin-top: 1rem!important;

                        .form-control {
                            position: relative;
                            -ms-flex: 1 1 auto;
                            flex: 1 1 auto;
                            width: 1%;
                            min-width: 0;
                            margin-bottom: 0;
                            border-right: 0;
                            display: block;
                            width: 100%;
                            height: calc(2.25rem + 2px);
                            padding: 0.375rem 0.75rem;
                            font-size: 1rem;
                            font-weight: 400;
                            line-height: 1.5;
                            color: #495057;
                            background-color: #fff;
                            background-clip: padding-box;
                            border: 1px solid #ced4da;
                            border-radius: 0.25rem;
                            box-shadow: inset 0 0 0 transparent;
                            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
                        }

                        .input-group-append {
                            display: flex;

                            .input-group-text {
                                background-color: transparent;
                                border-bottom-right-radius: 0.25rem;
                                border-left: 0;
                                border-top-right-radius: 0.25rem;
                                color: #777;
                                transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
                            }
                        }
                    }
                }
            }
        }
    }
</style>