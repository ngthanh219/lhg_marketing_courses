<template>
    <div
        class="w-content banner-wrap contact-form image-br"
        :style="{ 'background': 'url(' + $env.s3Url + 'banners/section8.jpg)' }"
    >
        <div class="content page">
            <img :src="$env.s3Url + 'banners/lien-he.png'" alt="" />
            <div class="wc-box" style="width: 90%; margin: 0 auto">
                <div class="c-form">
                    <div class="c-branch">
                        <div class="location-info">
                            <div class="item">
                                <div class="key">
                                    <i class="fas fa-map-marker-alt"></i>Địa chỉ:
                                </div>
                                <p>Trụ sở: 509/41/6 Đường Đại Mỗ, Quận Nam Từ Liêm, TP Hà Nội</p>
                                <p>VPĐD: Tòa nhà FLC, Đường Đại Mỗ, Quận Nam Từ Liêm, TP Hà Nội.</p>
                            </div>
                            <div class="item">
                                <div class="key">
                                    <i class="fas fa-phone-alt"></i>Hotline:
                                </div>
                                <p>0977834029</p>
                                <p>0984493633</p>
                                <p>0962933082</p>
                                <p>0835931015 (Zalo)</p>
                            </div>
                            <div class="item">
                                <div class="key">
                                    <i class="fas fa-envelope"></i> Email: <span>congtyphucminhtam@gmail.com</span>
                                </div>
                            </div>
                            <div class="item">
                                <div class="key">
                                    <i class="far fa-clock"></i> Giờ làm việc: <span>Thứ 2 - Thứ 7: 8h00 - 22h00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="#">
                        <div class="cf-title">Đăng ký thông tin</div>
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
                            <input type="text" class="form-control" placeholder="Tiêu đề *" v-model="form.title" />
                        </div>
                        <div class="input-group">
                            <textarea style="max-height: 100px; min-height: 100px" class="form-control" placeholder="Nội dung yêu cầu *" v-model="form.content"></textarea>
                        </div>
                        <div class="input-group">
                            <a href="#" class="btn btn-primary">Gửi yêu cầu</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BookContent',
    props: {
        
    },
    data() {
        return {
            form: {
                name: '',
                email: '',
                phone: '',
                title: '',
                content: ''
            }
        };
    },
    async mounted() {
        
    },
    methods: {
    }
}
</script>
