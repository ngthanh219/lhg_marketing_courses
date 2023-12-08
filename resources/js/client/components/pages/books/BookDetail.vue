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
                                <input type="text" class="form-control" placeholder="Họ tên *" v-model="form.name" />
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Email *" v-model="form.email" />
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Số điện thoại *" v-model="form.phone" />
                            </div>
                            <div class="input-group">
                                <textarea class="form-control" placeholder="Ghi chú" v-model="form.note"></textarea>
                            </div>
                        </div>
                        <div class="btn-action">
                            <a href="#" class="btn btn-danger">Đặt sách</a>
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

    export default {
        name: 'BookDetail',
        components: {
            MenuBanner1
        },
        data() {
            return {
                data: null,
                formDataError: {
                    message: ""
                },
                form: {
                    name: '',
                    email: '',
                    phone: '',
                    note: ''
                }
            };
        },
        async mounted() {
            await this.getBookData();

            this.form.name = this.$store.state.auth.user ? this.$store.state.auth.user.name : '';
            this.form.email = this.$store.state.auth.user ? this.$store.state.auth.user.email : '';
            this.form.phone = this.$store.state.auth.user ? this.$store.state.auth.user.phone : '';
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
                })
                .catch(err => {
                });
                this.$helper.setPageLoading(false);
            }
        }
    }
</script>
