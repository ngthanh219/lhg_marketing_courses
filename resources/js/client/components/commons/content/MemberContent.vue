<template>
    <div class="w-content reason">
        <div class="wc-box">
            <div class="box member">
                <div class="title top-slogan">Đội ngũ giảng viên</div>
                <div class="slogan small">Tất cả những giảng viên tại PMT GROUP đều là những giảng viên hàng đầu về Kinh doanh – Marketing, dày dặn kinh nghiệm thực chiến…</div>
                <img :src="$env.s3Url + 'banners/banner3.png'">
                <div class="bar-clear"></div>
                <div class="title">Đội ngũ PMT group</div>
                <div class="slogan small">Đội ngũ Trợ giảng và Hỗ trợ nhiệt tình, support 24/7 cho các bạn Học viên</div>
                <div class="members">
                    <div class="member">
                        <div class="information">
                            <img  :src="$env.s3Url + 'members/hoangthily.jpg'">
                            <div class="ci-name">Ms. Hoàng Lý</div>
                            <div class="ci-slogan">Facebook Marketing</div>
                        </div>
                    </div>
                    <div class="member">
                        <div class="information">
                            <img  :src="$env.s3Url + 'members/nguyenducmanh.jpg'">
                            <div class="ci-name">Mr. Nguyễn Đức Mạnh</div>
                            <div class="ci-slogan">Tool Marketing</div>
                        </div>
                    </div>
                    <div class="member">
                        <div class="information">
                            <img  :src="$env.s3Url + 'members/phantheanh.jpg'">
                            <div class="ci-name">Mr. Phan Thế Anh</div>
                            <div class="ci-slogan">Facebook Marketing - CEO</div>
                        </div>
                    </div>
                    <div class="member">
                        <div class="information">
                            <img  :src="$env.s3Url + 'members/nguyenthu.jpg'">
                            <div class="ci-name">Ms. Nguyễn Thư</div>
                            <div class="ci-slogan">Facebook Marketing</div>
                        </div>
                    </div>
                    <div class="member">
                        <div class="information">
                            <img  :src="$env.s3Url + 'members/nguyenminhtuan.jpg'">
                            <div class="ci-name">Mr. Nguyễn Minh Tuấn</div>
                            <div class="ci-slogan">Facebook ADS</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'MemberContent',
    props: {
        
    },
}
</script>
