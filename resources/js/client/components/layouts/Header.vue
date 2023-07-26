<template>
    <header>
        <div class="header-full-br">
            <div class="header-center-content">
                <div class="left-wrapper">
                    <div class="logo">
                        <router-link to="/">
                            <img src="https://marketing-courses-stg.s3.ap-southeast-1.amazonaws.com/general/logo.png" alt="">
                        </router-link>
                    </div>
                    <ul class="navbar-menu" v-bind:class="{'show-menu' : isShowMenu}">
                        <li>
                            <router-link to="/trang-chu">Trang chủ</router-link>
                        </li>
                        <li>
                            <router-link to="/khoa-hoc/hoc-tiktok">Hướng Dẫn Vào Học</router-link>
                        </li>
                        <li>
                            <input type="text" class="search" placeholder="Tìm khóa học">
                        </li>
                    </ul>
                </div>
                <div class="right-wrapper">
                    <div class="info-box" v-if="$store.state.auth.accessToken">
                        <div class="col">
                            <label>Thanhnt6@gmail.com</label>
                        </div>
                        <img src="#">
                    </div>
                    <div class="dropdown-actions" v-if="$store.state.auth.accessToken">
                        <div class="avatar-box">
                            <img src="#">
                        </div>
                        <div class="actions-box">
                            <p>
                                <router-link to="/">Trang cá nhân</router-link>
                            </p>
                            <form action="#">
                                <p>
                                    <a>Đăng xuất</a>
                                </p>
                            </form>
                        </div>
                    </div>

                    <ul class="navbar-menu" v-if="!$store.state.auth.accessToken">
                        <li class="information-user">
                            <router-link to="/dang-nhap">
                                <i class="fas fa-user"></i>
                                <span>Đăng nhập</span>
                            </router-link>
                        </li>
                        <li class="information-user">
                            <a to="/register">
                                <i class="fas fa-user-plus"></i>
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
            }
        },
        mounted() {
        },
        methods: {
            logout() {
                
            },
            
            showMenu(e) {
                e.preventDefault();
                
                this.isShowMenu = !this.isShowMenu;
            }
        }
    }
</script>
