<template>
    <div class="content-wrapper page-component">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                Trang chủ
                            </li>
                            <li class="breadcrumb-item active">Thông tin đặt sách</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group input-group-sm">
                            <label>Tên người dùng</label>
                            <input type="text" class="form-control" placeholder="Tên khóa học" v-model="query.name">
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-group input-group-sm">
                            <a href="/" class="btn btn-primary" @click="filter">Lọc</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <TablePagination
                                v-if="dataList"
                                :dataList="dataList"
                                :query="query"
                                :getData="getBookUserData"
                            />

                            <div class="card-body data-table table-responsive p-0">
                                <table class="table text-center table-hover table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width: 25px">
                                                <a href="/" @click="sortBookUserData($event, 'id_sort')">
                                                    ID
                                                    <i
                                                        class="id-icon fas"
                                                        v-bind:class="[
                                                            query.id_sort == 'asc' ? 'fa-arrow-up' : 'fa-arrow-down'
                                                        ]"
                                                    />
                                                </a>
                                            </th>
                                            <th style="width: 250px">Sách</th>
                                            <th style="width: 250px">Tài khoản đăng ký</th>
                                            <th style="width: 250px">Giá</th>
                                            <th style="width: 250px">Giảm giá</th>
                                            <th style="width: 250px">Giá khuyến mãi</th>
                                            <th style="width: 250px">Trạng thái</th>
                                            <th style="width: 250px">Ngày tạo</th>
                                            <th style="width: 100px"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data" v-if="dataList">
                                        <tr v-for="data, index in dataList.list">
                                            <td>{{ data.id }}</td>
                                            <td>{{ data.book.name }}</td>
                                            <td>{{ data.other_email }}</td>
                                            <td>{{ parseInt(data.price).toLocaleString() + 'đ' }}</td>
                                            <td>{{ data.discount }}%</td>
                                            <td>{{ parseInt(data.discount_price).toLocaleString() + 'đ' }}</td>
                                            <td>
                                                <span 
                                                    class="badge" 
                                                    v-bind:class="[
                                                        data.status == 0 ? 'alert-success' : 'alert-secondary'
                                                    ]"
                                                >
                                                    {{ data.status == 0 ? 'Đã xác nhận' : 'Đang yêu cầu' }}
                                                </span>
                                            </td>
                                            <td>{{ data.created_at }}</td>
                                            <td>
                                                <div class="table-action">
                                                    <div class="action-btn">
                                                        <div>
                                                            <div class="dot"></div>
                                                            <div class="dot"></div>
                                                            <div class="dot"></div>
                                                        </div>
                                                    </div>
                                                    <div class="action-detail">
                                                        <a class="action-detail-btn" v-if="query.is_deleted == 0" @click="openForm($event, index, dataList.list[index])">
                                                            <i class="fas fa-eye"></i>
                                                            <div class="icon-wrap">Xem thông tin</div>
                                                        </a>
                                                        <a class="action-detail-btn" @click="deleteData($event, data.id)">
                                                            <i 
                                                                class="fas"
                                                                v-bind:class="[
                                                                    query.is_deleted == 0 ? 'fa-trash' : 'fa-window-restore'
                                                                ]"
                                                            />
                                                            <div class="icon-wrap">
                                                                {{ query.is_deleted == 0 ? 'Xóa' : 'Khôi phục' }}
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-if="dataList && dataList.list.length == 0">
                                        <tr>
                                            <td colspan="10">Không có dữ liệu</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <BookUserInformation
            v-if="isForm"

            :closeForm="closeForm"
            :bookUserData="data"
            :getBookUserData="getBookUserData"
        />
    </div>
</template>

<script>
    import TablePagination from '../../commons/pagination/TablePagination.vue';
    import BookUserInformation from './BookUserInformation.vue';

    export default {
        name: "BookUser",
        components: { 
            TablePagination,
            BookUserInformation
        },
        data() {
            return {
                dataList: null,
                query: {
                    limit: 15,
                    page: 1,
                    id_sort: "desc",
                    name: "",
                    is_deleted: 0
                },
                formDataError: {
                    message: ""
                },
                isForm: false,
                data: null
            };
        },
        mounted() {
            this.$helper.getCurrentQuery(this.query);

            this.getBookUserData();
        },
        methods: {
            async getBookUserData() {
                this.$helper.setPageLoading(true);
                await this.$store.dispatch("getBookUsers", {
                    query: this.$helper.getQueryString(this.query),
                    error: this.formDataError
                })
                .then(res => {
                    this.dataList = res.data;
                })
                .catch(err => {
                });
                this.$helper.setPageLoading(false);
            },

            filter(e) {
                e.preventDefault();

                this.$helper.pushQueryUrl(this.query);

                if (this.query.page >= this.dataList.total_page) {
                    this.query.page = this.dataList.total_page;
                }

                if (this.query.page == 0) {
                    this.query.page = 1;
                }

                this.getBookUserData();
            },

            sortBookUserData(e, queryParam) {
                e.preventDefault();

                if (this.query[queryParam] == "desc") {
                    this.query[queryParam] = "asc";
                } else {
                    this.query[queryParam] = "desc";
                }

                this.$helper.pushQueryUrl(this.query);
                this.getBookUserData();
            },

            openForm(e, index, data) {
                e.preventDefault();

                if (typeof (index) !== 'undefined') {
                    this.data = data;
                    this.data['index'] = index;
                } else {
                    this.data = null;
                }

                this.isForm = true;
            },

            closeForm(e) {
                e.preventDefault();

                this.data = null;
                this.isForm = false;
            },

            async deleteData(e, id) {
                e.preventDefault();

                var alertMessage = 'Bạn muốn xóa thông tin này?';
                var successMessage = 'Xóa thành công';
                if (this.query.is_deleted == 1) {
                    alertMessage = 'Bạn muốn khôi phục thông tin này?';
                    successMessage = 'Khôi phục thành công';
                }

                if (confirm(alertMessage)) {
                    this.$helper.setPageLoading(true);
                    await this.$store.dispatch("deleteBookUser", {
                        id: id,
                        error: this.formDataError
                    })
                    .then(res => {
                        this.$helper.setNotification(1, successMessage);
                    })
                    .catch(err => {

                    });

                    this.getBookUserData();
                }
            }
        }
    }
</script>
