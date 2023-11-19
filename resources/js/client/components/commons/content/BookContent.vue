<template>
    <div class="card-list">
        <div class="card-item" v-if="dataList" v-for="book in dataList.list">
            <router-link :to="'sach/' + book.slug">
                <div class="c-image">
                    <img :src="book.image_url" alt="">
                </div>
                <div class="c-info">
                    <div class="theme text-line-3">{{ book.name }}</div>
                    <div class="description">
                        {{ book.description }}
                    </div>
                    <div class="detail" style="flex-direction: row-reverse;">
                        <a class="btn btn-success show">
                            Chi tiết <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </router-link>
        </div>
        <div class="card-item" v-else v-for="index in 6">
            <br v-for="index in 16">
        </div>
    </div>
</template>

<script>
export default {
    name: 'BookContent',
    props: {
        filterValue: Number,
        setIsShowLoadPage: Function
    },
    data() {
        return {
            dataList: {
                list: [
                    {
                        image_url: 'https://pmt.academy/wp-content/uploads/2022/03/z3444294826274_f429b011b8048ad55d7aa3a581188ed3.jpg',
                        name: 'Dịch vụ chạy quảng cáo facebook trọn đời',
                        description: 'Trọn gói dịch vụ chạy quảng cáo facebook  chỉ 1.500.000đ / tháng – uy tín, [...]',
                        slug: 'dich-vu-chay-quang-cao-fb'
                    },
                    {
                        image_url: 'https://pmt.academy/wp-content/uploads/2022/03/z3440857628136_0c7dfc16c5ceb36fe05abf601b52566c.jpg',
                        name: 'Khóa học Facebook ADS Coaching 1:1.',
                        description: 'Khóa học facebook ads coaching 1:1 – liên hệ ngay để được tư vấn thêm [...]',
                        slug: 'khoa-hoc-fb'
                    },
                    {
                        image_url: 'https://pmt.academy/wp-content/uploads/2022/03/z3440857398001_e5e0ff686b2a9d55257aab2be07236a4.jpg',
                        name: 'Cung cấp tài khoản chạy quảng cáo.',
                        description: 'Bán tài khoản quảng cáo facebook business tài khoản quảng cáo facebook business là một [...]',
                        slug: 'cung-cap-tai-khoan-ads'
                    },
                    {
                        image_url: 'https://pmt.academy/wp-content/uploads/2022/03/3a5d079e39dbcf8596ca-20210824053024-300x200.jpg',
                        name: 'Cố Vấn Phát Triển Thương Hiệu 1:1',
                        description: 'Cố vấn phát triển thương hiệu 1:1 – hãy kết nối với tôi khi bạn [...]',
                        slug: 'co-van-phat-trien-thuong-hieu'
                    },
                ]
            },
            query: {
                limit: 15,
                page: 1,
                id_sort: "desc",
                name: ""
            },
            formDataError: {
                message: ""
            },
        };
    },
    async mounted() {
        // await this.getBooksData();

        // this.checkPage();
    },
    methods: {
        // checkPage() {
        //     if (typeof(this.setIsShowLoadPage) === 'function') {
        //         if (this.dataList.total_page <= 1) {
        //             this.setIsShowLoadPage(false);
        //         } else {
        //             this.setIsShowLoadPage(true);
        //         }
        //     }
        // },
        
        // setDataListNull() {
        //     this.dataList = null;
        // },

        // getData() {
        //     return {
        //         dataList: this.dataList,
        //         query: this.query
        //     };
        // },

        // async getBooksDataWithQuery(query) {
        //     this.$helper.mergeArrayData(query, this.query);

        //     await this.getBooksData();
        // },

        // async getBooksData() {
        //     this.$helper.setPageLoading(true);
        //     await this.$store.dispatch("getBooks", {
        //         query: this.$helper.getQueryString(this.query),
        //         error: this.formDataError
        //     })
        //     .then(res => {
        //         if (this.dataList == null) {
        //             this.dataList = res.data;
        //         } else {
        //             for (var index in res.data.list) {
        //                 this.dataList.list.push(res.data.list[index]);
        //             }
        //         }
        //     })
        //     .catch(err => {
        //     });
        //     this.$helper.setPageLoading(false);
        // }
    }
}
</script>
