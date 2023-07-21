<template>
    <div class="popup-component">
        <div class="pc-form" v-bind:class="{ 'transition-active': isTransitionActive }">
            <div class="content">
                <div class="container-fluid" style="width: 60%">
                    <div class="row">
                        <div class="col-md-12">
                            <form @submit="handleData">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            {{ userData ? 'Thông tin tài khoản' : 'Thêm mới tài khoản' }}
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <select class="form-control" v-model="formData.is_login">
                                                <option value="0">Chưa đăng nhập</option>
                                                <option value="1">Đã đăng nhập</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Chức vụ</label>
                                            <select class="form-control" v-model="formData.role_id">
                                                <option value="0">Admin</option>
                                                <option value="1">Người dùng</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Họ tên</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.name">
                                        </div>
                                        <div class="form-group">
                                            <label>Số điện thoại</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.phone">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.email">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="customCheckbox2" v-model="formData.is_change_password" :checked="formData.is_change_password == 1">
                                                <label for="customCheckbox2" class="custom-control-label cursor-pointer">Đổi mật khẩu</label>
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="formData.is_change_password == 1">
                                            <label>Mật khẩu</label>
                                            <input type="text" class="form-control form-control-border" placeholder="xxx" v-model="formData.password">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-2" v-bind:class="{
                                            disabled: !(this.$helper.checkChangeFormData(userData, formData) || formData.is_change_password == 1)
                                        }">
                                            {{ userData ? 'Cập nhật' : 'Thêm mới' }}
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
        name: "UserInformation",
        props: {
            closeForm: Function,
            userData: Object
        },
        data() {
            return {
                isTransitionActive: false,
                formData: {
                    name: null,
                    email: null,
                    phone: null,
                    is_login: null,
                    role_id: null,
                    is_change_password: 0,
                    password: '123456'
                },
                formDataError: {
                    message: '',
                    name: '',
                    email: '',
                    phone: '',
                    is_login: '',
                    role_id: '',
                    is_change_password: '',
                    password: '',
                }
            }
        },
        mounted() {
            this.$helper.scrollTop()

            setTimeout(() => {
                this.isTransitionActive = true;
                this.$helper.mergeArrayData(this.userData, this.formData)
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

            handleData(e) {
                e.preventDefault();

                if (this.userData) {
                    if (this.$helper.checkChangeFormData(this.userData, this.formData) || this.formData.is_change_password == 1) {
                        this.$helper.setPageLoading(true);
                        this.update();
                    }
                } else {
                    this.$helper.setPageLoading(true);
                    this.create();
                }
            },

            create() {
                console.log('create');
                this.$helper.setPageLoading(false);
            },

            async update() {
                await this.$store.dispatch("updateUser", {
                    id: this.userData.id,
                    request: this.$helper.appendFormData(this.formData),
                    error: this.formDataError
                })
                .then(res => {
                    this.formData.is_change_password = 0;
                    this.$helper.mergeArrayData(this.formData, this.userData);
                    this.$helper.setNotification(1, 'Cập nhật thành công');
                })
                .catch(err => {

                });
                this.$helper.setPageLoading(false);
            }
        }
    }
</script>
