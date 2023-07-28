<template>
    <div class="wrapper grey-br">
        <MenuBanner
            :pageName="'Đăng ký khóa học'"
        />
        
        <div class="w-content c-detail page">
            <div class="wc-information mg-0">
                <div class="box-card">
                    <div class="tab-detail pd-tab">
                        <h3>Phương thức thanh toán</h3>
                        <div class="form-information pay">
                            <div class="description">
                                Thanh toán bằng phương thức chuyển khoản hoặc quét mã QR
                            </div>
                            <div class="image">
                                <img src="https://marketing-courses-stg.s3.ap-southeast-1.amazonaws.com/images/qr.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-card">
                    <div class="tab-detail pd-tab">
                        <h3>Thông tin liên hệ</h3>
                        <div class="form-information">
                            <form action="#">
                                <div class="input-group">
                                    <input type="name" class="form-control" placeholder="Họ tên *">
                                </div>
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="Email *" name="email">
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Số điện thoại *" @keypress="this.$helper.isNumber">
                                </div>
                                <div class="input-group custom-file-input">
                                    Chọn ảnh xác nhận đã thanh toán
                                    <input type="file" class="form-control" placeholder="Ảnh thanh toán">
                                </div>
                                <div class="input-group ">
                                    <textarea class="form-control" placeholder="Ghi chú thêm"></textarea>
                                </div>
                                <div class="input-group">
                                    <button type="submit" class="btn btn-danger btn-block">Đăng ký khóa học ngay</button>
                                    <!-- <div class="btn btn-danger btn-block btn-loading disabled">
                                        <div class="loading">
                                            <BtnLoading />
                                        </div>
                                    </div> -->
                                </div>
                            </form>
                            
                            <div class="fi-description wc-general-information">
                                <div class="gi-card">
                                    <div class="gic-info">
                                        <h3>Thông tin khóa học</h3>
                                        <div class="gic-info-item">
                                            <i class="fa fa-book"></i>
                                            Tên khóa học: <strong>Tạo kênh youtube chuẩn & thiết kế canva</strong>
                                        </div>
                                        <div class="gic-info-item">
                                            <i class="fa fa-shopping-cart"></i>
                                            Giá đăng ký: 
                                            <strong> 1.950.000<sup>đ</sup></strong>
                                        </div>
                                        <div class="gic-info-item">
                                            <i class="fa fa-clock"></i>
                                            Thời lượng: 
                                            <strong>13 phút</strong>
                                        </div>
                                        <div class="gic-info-item">
                                            <i class="fa fa-play"></i>
                                            Giáo trình: 
                                            <strong>3 bài giảng</strong>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MenuBanner from '../../commons/banner/MenuBanner.vue';
    import BtnLoading from '../../commons/loading/BtnLoading.vue';

    export default {
        name: 'RegisterCourse',
        components: {
            MenuBanner,
            BtnLoading
        }
    }
</script>
