<template>
    <header>
        <div class="header-full-br" >
            <div class="header-center-content">
                <div class="left-wrapper">
                    <div class="logo">
                        <a class="cursor-pointer" @click="redirectPage($event, '')">
                            <img src="https://marketing-courses-stg.s3.ap-southeast-1.amazonaws.com/general/logo.png" alt="">
                        </a>
                    </div>
                    <ul class="navbar-menu" v-bind:class="[
                        {'show-menu' : isShowMenu},
                        {'content' : isActiveTransactionMenu},
                    ]">
                        <li>
                            <a class="cursor-pointer" @click="redirectPage($event, 'trang-chu')">Trang chủ</a>
                        </li>
                        <li>
                            <a class="cursor-pointer" @click="redirectPage($event, 'courses')">Khóa học</a>
                        </li>
                        <li>
                            <a href="#">Hướng Dẫn Vào Học</a>
                        </li>
                        <li>
                            <input type="text" class="search" placeholder="Tìm khóa học">
                        </li>
                        <li class="toggler-active" v-if="!$store.state.auth.accessToken">
                            <a class="cursor-pointer" @click="redirectPage($event, 'dang-nhap')">
                                <span>Đăng nhập</span>
                            </a>
                        </li>
                        <li class="toggler-active" v-if="!$store.state.auth.accessToken">
                            <a class="cursor-pointer" @click="redirectPage($event, 'dang-ky')">
                                <span>Đăng ký</span>
                            </a>
                        </li>
                        <li class="toggler-active" v-if="$store.state.auth.accessToken">
                            <a class="cursor-pointer">
                                <span>Tài khoản: {{ $store.state.auth.user.email }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="right-wrapper">
                    <div class="navbar-menu" v-if="$store.state.auth.accessToken">
                        <div class="col">
                            <label>Tài khoản: {{ $store.state.auth.user.email }}</label>
                        </div>
                    </div>
                    <ul class="navbar-menu" v-if="!$store.state.auth.accessToken">
                        <li class="information-user">
                            <a class="cursor-pointer" @click="redirectPage($event, 'dang-nhap')">
                                <span>Đăng nhập</span>
                            </a>
                        </li>
                        <li class="information-user">
                            <a class="cursor-pointer" @click="redirectPage($event, 'dang-ky')">
                                <span>Đăng ký</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="toggler">
                    <a @click="showMenu">
                        <i class="fa-solid fa fa-bars"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
    export default {
        name: "Header",
        data() {
            return {
                isShowMenu: false,
                isActiveTransactionMenu: false,
            }
        },
        mounted() {
        },
        methods: {
            logout() {
                
            },
            
            showMenu(e) {
                e.preventDefault();
                
                if (!this.isShowMenu) {
                    this.isShowMenu = true;

                    setTimeout(() => {
                        this.isActiveTransactionMenu = true;
                    }, 50);
                } else {
                    this.closeHeader();
                }
            },

            closeHeader() {
                this.isActiveTransactionMenu = false;

                setTimeout(() => {
                    this.isShowMenu = false;
                }, 400);
            },

            redirectPage(e, path) {
                e.preventDefault();

                this.$helper.redirectPage(path);
                this.isActiveTransactionMenu = false;
                this.closeHeader();
            }
        }
    }
</script>
