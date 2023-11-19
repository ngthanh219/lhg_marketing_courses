<template>
    <div class="wrapper">
        <FirstBanner />

        <div class="slogan">
            Học chiến lược tư duy & công cụ marketing giúp bạn 10x thu nhập
        </div>

        <div class="reason">
            <div class="reason-container page">
                <h3>Tại sao bạn nên lựa chọn chúng tôi?</h3>
                <div class="reason-box">
                    <div class="rb-item">
                        <div class="image">
                            <img :src="$env.s3Url + 'banners/rs1.png'" alt="">
                        </div>
                        <p>Học mọi lúc mọi nơi</p>
                        <span>Chỉ cần có máy tính, laptop hoặc TV kết nối internet</span>
                    </div>
                    <div class="rb-item">
                        <div class="image">
                            <img :src="$env.s3Url + 'banners/rs2.png'" alt="">
                        </div>
                        <p>Chất lượng</p>
                        <span>Khóa học chất lượng, cập nhật liên tục, nhu cầu cao, dễ chia sẻ</span>
                    </div>
                    <div class="rb-item">
                        <div class="image">
                            <img :src="$env.s3Url + 'banners/rs3.png'" alt="">
                        </div>
                        <p>Thanh toán 1 lần</p>
                        <span>Thanh toán 1 lần, học tất cả các khóa học</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="w-content page">
            <div class="wc-box">
                <div class="title">Khóa học</div>
                <CourseContent />

                <div class="action flex-center">
                    <router-link to="/khoa-hoc" class="btn btn-primary">Xem thêm</router-link>
                </div>
            </div>
        </div>

        <div class="bar-clear"><div class="dash"></div></div>

        <div class="w-content page">
            <div class="wc-box">
                <div class="title">Sách</div>
                <BookContent />

                <!-- <div class="action flex-center">
                    <router-link to="/sach" class="btn btn-primary">Xem thêm</router-link>
                </div> -->
            </div>
        </div>

        <div class="bar-clear"><div class="dash"></div></div>

        <div class="reason">
            <div class="reason-container page">
                <h3>Khách hàng PMT Group</h3>
                
                <div class="list">
                    <img src="https://pmt.academy/wp-content/uploads/2022/04/kh1.png">
                    <img src="https://pmt.academy/wp-content/uploads/2022/04/kh2.png">
                    <img src="https://pmt.academy/wp-content/uploads/2022/04/kh3.png">
                    <img src="https://pmt.academy/wp-content/uploads/2022/04/kh4.png">
                    <img src="https://pmt.academy/wp-content/uploads/2022/04/kh5.png">
                    <img src="https://pmt.academy/wp-content/uploads/2022/04/kh6.png">
                </div>
            </div>
        </div>

        <div class="w-content page">
            <div class="wc-box">
                <div class="title">Đội ngũ PMT group</div>
                
                <div class="box">
                    <div class="ceo">
                        <div class="information">
                            <img src="https://pmt.academy/wp-content/uploads/2022/05/z3438831536334_2b1c050a17eab0bdacbc747ee0e875b8.jpg" alt="">
                            <div class="ci-name">Ms. Lại Hồng Gấm</div>
                            <div class="ci-slogan">Founder - CEO</div>
                        </div>
                        <div class="detail-card">
                            <div class="item">
                                <div class="position">CEO CÔNG TY CỔ PHẦN PMT GROUP.</div>
                                <div class="description">
                                    <p>Chuyên cung cấp các sản phẩm làm đẹp da, chăm sóc body, sản phẩm chăm sóc tóc , sức khỏe, tpcn.</p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="position">TỔNG GIÁM ĐỐC CÔNG TY CỔ PHẦN PMT GROUP.</div>
                                <div class="description">
                                    <p>Tổng giám đốc công ty phụ trách và điều hành hệ thống văn phòng dịch vụ chạy quảng cáo Facebook, TikTok,….</p>
                                    <p>Trực tiếp đào tạo học viên các khóa học chạy quảng cáo trên toàn quốc.</p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="position">Kinh nghiệm 11+ năm SEO Maketing Online.</div>
                                <div class="description">
                                    <p>Hệ thống phát triểnđa kênh Online thực chiến : Youtube – Google – Facebook – TikTok – Zalo,…</p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="position">Kinh nghiệm 7+ năm Facebook</div>
                                <div class="description">
                                    <p>Đồng hành phát triển cùng nhiều dự án công ty thuộc đa ngành đa hệ sản phẩm: bất động sản, mỹ phẩm, spa, thẩm mỹ, ăn uống , thời trang, phụ kiện, sản xuất, du lịch, chăn nuôi, ô tô, sản phẩm chăm sóc sức khỏe, bệnh viện, mua sắm, thực phẩm chức năng, giáo dục, kinh doanh,…</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bar-clear"><div class="dash"></div></div>
                    <div class="members">
                        <div class="member">
                            <div class="information">
                                <img src="https://pmt.academy/wp-content/uploads/2022/05/z3438793389274_0757006b02e43e4c1703cd492af8d05c.jpg" alt="">
                                <div class="ci-name">Ms. Hoàng Thị Lý</div>
                                <div class="ci-slogan">Facebook Marketing</div>
                            </div>
                            <div class="detail-card">
                                <div class="item">
                                    <div class="position">Giám đốc cơ sở 2 Đà Lạt</div>
                                    <div class="description">
                                        <p>Chuyên cung cấp các giải pháp dịch vụ quảng cáo, đào tạo chạy quảng cáo Facebook, Maketing Online.</p>
                                        <p>05 Năm kinh nghiệm trong nghề KDOL.</p>
                                        <p>Đào tạo huấn luyện học viên chạy quảng cáo, tổ chức khóa học cộng đồng trên toàn quốc.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="member">
                            <div class="information">
                                <img src="https://pmt.academy/wp-content/uploads/2023/11/IMG_3255-e1698810828233.jpg" alt="">
                                <div class="ci-name">Mr. Nguyễn Đức Mạnh</div>
                                <div class="ci-slogan">Tool Marketing</div>
                            </div>
                            <div class="detail-card">
                                <div class="item">
                                    <div class="position">Kỹ Thuật Viên PMT Group</div>
                                    <div class="description">
                                        <p>Kinh nghiệm 5 năm Facebook Marketing, Copywriting, các kênh Digital Ads.</p>
                                        <p>Chuyên cung cấp các công cụ hỗ trợ Facebook, Zalo, Maketing Online.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="member">
                            <div class="information">
                                <img src="https://pmt.academy/wp-content/uploads/2023/11/1.jpg" alt="">
                                <div class="ci-name">Mr. Phan Thế Anh</div>
                                <div class="ci-slogan">Facebook Marketing - CEO</div>
                            </div>
                            <div class="detail-card">
                                <div class="item">
                                    <div class="position">Kỹ Thuật Viên PMT Group</div>
                                    <div class="description">
                                        <p>Kinh nghiệm giảng dạy và hỗ trợ quảng cáo Facebook.</p>
                                        <p>Đào tạo và giảng dạy quy trình chạy quảng cáo Facebook, google ads,…Với kinh nghiệm hơn 10 năm trong nghề sales marketing online và offline.</p>
                                        <p>05 năm kinh nghiệm đứng lớp giảng dạy các khoá từ cơ bản đến chuyên sâu về facebook , google ADS …</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="member">
                            <div class="information">
                                <img src="https://pmt.academy/wp-content/uploads/2023/11/2.jpg" alt="">
                                <div class="ci-name">Ms. Nguyễn Thư</div>
                                <div class="ci-slogan">Facebook Marketing</div>
                            </div>
                            <div class="detail-card">
                                <div class="item">
                                    <div class="position">Kỹ Thuật Viên PMT Group</div>
                                    <div class="description">
                                        <p>Chuyên cung cấp các giải pháp dịch vụ quảng cáo, đào tạo chạy quảng cáo Facebook, Maketing Online.</p>
                                        <p>03 Năm kinh nghiệm trong nghề KDOL.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ContactContent />
        
        <div class="w-content page">
            <div class="wc-box">
                <div class="title">Bài viết nổi bật</div>
                <PostContent />

                <div class="action flex-center">
                    <router-link to="/bai-viet" class="btn btn-primary">Xem thêm</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FirstBanner from '../commons/banner/FirstBanner.vue';
    import CourseContent from '../commons/content/CourseContent.vue';
    import PostContent from '../commons/content/PostContent.vue';
    import BookContent from '../commons/content/BookContent.vue';
    import ContactContent from '../commons/content/ContactContent.vue';

    export default {
        name: 'Home',
        components: {
            FirstBanner,
            CourseContent,
            PostContent,
            BookContent,
            ContactContent
        },
        mounted() {
            
        }
    }
</script>
