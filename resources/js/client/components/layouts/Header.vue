<template>
    <header v-bind:class="{'h-fixed' : isShowMenu}">
        <div class="header-full-br" >
            <div class="header-center-content">
                <div class="left-wrapper">
                    <div class="logo">
                        <router-link to="/">
                            <img src="https://marketing-courses-stg.s3.ap-southeast-1.amazonaws.com/general/logo.png" alt="">
                        </router-link>
                    </div>
                    <ul class="navbar-menu" v-bind:class="[
                        {'show-menu' : isShowMenu},
                        {'content' : isActiveTransactionMenu},
                    ]">
                        <li>
                            <router-link to="/trang-chu">Trang chủ</router-link>
                        </li>
                        <li>
                            <router-link to="/courses">Khóa học</router-link>
                        </li>
                        <li>
                            <a href="#">Hướng Dẫn Vào Học</a>
                        </li>
                        <li>
                            <input type="text" class="search" placeholder="Tìm khóa học">
                        </li>
                        <li class="toggler-active" v-if="!$store.state.auth.accessToken">
                            <router-link to="/dang-nhap">
                                <span>Đăng nhập</span>
                            </router-link>
                        </li>
                        <li class="toggler-active" v-if="!$store.state.auth.accessToken">
                            <router-link to="/dang-ky">
                                <span>Đăng ký</span>
                            </router-link>
                        </li>
                        <li class="toggler-active" v-if="$store.state.auth.accessToken">
                            <router-link to="/dang-nhap">
                                <span>Tài khoản: {{ $store.state.auth.user.email }}</span>
                            </router-link>
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
                            <router-link to="/dang-nhap">
                                <span>Đăng nhập</span>
                            </router-link>
                        </li>
                        <li class="information-user">
                            <router-link to="/dang-ky">
                                <span>Đăng ký</span>
                            </router-link>
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
                    this.isActiveTransactionMenu = false;

                    setTimeout(() => {
                        this.isShowMenu = false;
                    }, 300);
                }
                
            }
        }
    }
</script>
