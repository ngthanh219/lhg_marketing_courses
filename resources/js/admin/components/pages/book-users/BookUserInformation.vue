<template>
    <div class="popup-component" v-bind:class="{ 'transition-active': !isTransitionActive }">
        <div class="pc-form" v-bind:class="{ 'transition-active': isTransitionActive }">
            <div class="content">
                <div class="container-fluid" style="width: 40%">
                    <div class="row">
                        <div class="col-md-12">
                            <form @submit="handleData">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            Thông tin chi tiết
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <select class="form-control" v-model="formData.status">
                                                <option value="0">Đã xác nhận</option>
                                                <option value="1">Đang yêu cầu</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Tài khoản đăng ký</label>
                                            <input type="text" class="form-control form-control-border" :value="bookUserData.user_email ?? 'Khách vãng lai'" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Họ tên</label>
                                            <input type="text" class="form-control form-control-border" :value="bookUserData.other_name" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control form-control-border" :value="bookUserData.other_email" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Số điện thoại</label>
                                            <input type="text" class="form-control form-control-border" :value="bookUserData.other_phone" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Tên sách</label>
                                            <input type="text" class="form-control form-control-border" :value="bookUserData.book.name" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Giá</label>
                                            <input type="text" class="form-control form-control-border" :value="parseInt(bookUserData.price).toLocaleString() + 'đ'" disabled>
                                        </div>
                                        <div class="form-group" v-if="bookUserData.discount > 0">
                                            <label>Giá giảm còn</label>
                                            <input type="text" class="form-control form-control-border" :value="parseInt(bookUserData.discount_price).toLocaleString() + 'đ'" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>Ngày đăng ký</label>
                                            <input type="text" class="form-control form-control-border" :value="bookUserData.created_at" disabled>
                                        </div>
                                        <div class="form-group" v-if="bookUserData.note">
                                            <label>Mô tả</label>
                                            <textarea class="form-control" :value="bookUserData.note" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-2">Cập nhật</button>
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
        name: "BookUserInformation",
        components: {
        },
        props: {
            closeForm: Function,
            getBookUserData: Function,
            bookUserData: Object
        },
        data() {
            return {
                isTransitionActive: false,
                formData: {
                    status: 1
                },
                formDataError: {
                    message: '',
                    status: ''
                }
            }
        },
        mounted() {
            this.$helper.scrollTop()

            setTimeout(() => {
                this.isTransitionActive = true;

                if (this.bookUserData) {
                    this.$helper.mergeArrayData(this.bookUserData, this.formData);
                }
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

                this.$helper.setPageLoading(true);
                await this.update();
            },

            async update() {
                await this.$store.dispatch("updateBookUser", {
                    id: this.bookUserData.id,
                    request: this.$helper.appendFormData(this.formData),
                    error: this.formDataError
                })
                .then(res => {
                    this.$helper.mergeArrayData(this.formData, this.bookUserData);
                    this.$helper.setNotification(1, 'Cập nhật thành công');
                })
                .catch(err => {

                });

                this.$helper.setPageLoading(false);
            },
        }
    }
</script>
