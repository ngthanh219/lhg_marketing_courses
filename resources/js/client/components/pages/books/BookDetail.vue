<template>
    <div class="wrapper" v-if="data">
        <MenuBanner1
            :directory="'Sách / '"
            :pageName="data.name"
        />

        <div class="w-content c-detail page">
            <div class="wc-information">
                <div class="title">{{ data.name }}</div>
                <div class="box-card">
                    <div class="tab-detail no-border">
                        <div class="description" v-html="data.description"></div>
                    </div>
                </div>
            </div>
            
            <div class="wc-general-information">
                <div class="gi-card">
                    <div class="gic-image">
                        <img :src="data.image_url" alt="" style="object-fit: scale-down;">
                    </div>
                    <div class="gic-action">
                        <div class="price-box-theme">
                            <div class="price">
                                <strong>
                                    {{ data.discount > 0 ? parseInt(data.discount_price).toLocaleString() : parseInt(data.price).toLocaleString() }}<sup>đ</sup>
                                </strong>
                                <del v-if="data.discount > 0">
                                    {{ parseInt(data.price).toLocaleString() }}<sup>đ</sup>
                                </del>
                            </div>
                            <span class="discount-price" v-if="data.discount > 0">-{{ data.discount }}%</span>
                        </div>
                        
                        <div class="gic-info" style="padding: 0 0 10px 0">
                            <div class="title">
                                Để lại thông tin!
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Họ tên *" v-model="formData.name" />
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Email *" v-model="formData.email" />
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Số điện thoại *" v-model="formData.phone" />
                            </div>
                            <div class="input-group">
                                <textarea class="form-control" placeholder="Ghi chú" v-model="formData.note"></textarea>
                            </div>
                        </div>
                        <div class="btn-action" v-if="!isRegisterClick">
                            <a @click="registerBook" class="btn btn-danger" ref="registerBookBtn">Đặt sách</a>
                        </div>
                        <div class="btn btn-action btn-danger btn-block btn-loading disabled" v-else :style="{ height: registerBookBtnHeight + 'px'}">
                            <div class="loading">
                                <BtnLoading />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear-text"></div>
    </div>
</template>

<script>
    import MenuBanner1 from '../../commons/banner/MenuBanner1.vue';
    import BtnLoading from '../../commons/loading/BtnLoading.vue';

    export default {
        name: 'BookDetail',
        components: {
            MenuBanner1,
            BtnLoading
        },
        data() {
            return {
                data: null,
                formDataError: {
                    message: ""
                },
                formData: {
                    book_id: null,
                    name: '',
                    email: '',
                    phone: '',
                    note: ''
                },
                isRegisterClick: false,
                registerBookBtnHeight: 0
            };
        },
        async mounted() {
            await this.getBookData();

            this.formData.name = this.$store.state.auth.user ? this.$store.state.auth.user.name : '';
            this.formData.email = this.$store.state.auth.user ? this.$store.state.auth.user.email : '';
            this.formData.phone = this.$store.state.auth.user ? this.$store.state.auth.user.phone : '';
        },
        methods: {
            async getBookData() {
                this.$helper.setPageLoading(true);
                await this.$store.dispatch("getBookDetail", {
                    slug: this.$route.params.bookSlug,
                    error: this.formDataError
                })
                .then(res => {
                    this.data = res.data;
                    this.formData.book_id = this.data.id;
                })
                .catch(err => {
                });
                this.$helper.setPageLoading(false);
            },

            async registerBook(e) {
                e.preventDefault();

                this.registerBookBtnHeight = this.$refs.registerBookBtn.clientHeight - 10;
                this.isRegisterClick = true;
                if (this.isRegisterClick) {
                    await this.$store.dispatch('registerBook', {
                        request: this.$helper.appendFormData(this.formData),
                        error: this.formDataError
                    })
                    .then(res => {
                        for (var item in this.formData) {
                            this.formData[item] = '';
                        }
                        
                        this.$helper.setNotification(1, 'Chúng tôi đã nhận được thông tin của bạn và sẽ liên lạc với bạn sớm nhất')
                    })
                    .catch(err => {
                        
                    });

                    this.registerBookBtnHeight = 0;
                    this.isRegisterClick = false;
                }
            }
        }
    }
</script>
