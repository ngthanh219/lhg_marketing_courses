<template>
    <div class="content-wrapper page-component">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a href="/" class="btn btn-primary" @click="openForm">
                            <i class="id-icon fas fa-plus mr-2"></i>Thêm mới
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                Trang chủ
                            </li>
                            <li class="breadcrumb-item active">Quản lý người dùng</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group input-group-sm">
                            <label>Thông tin</label>
                            <input type="text" class="form-control" placeholder="Email, số điện thoại" v-model="query.information">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group input-group-sm">
                            <label>Trạng thái</label>
                            <select class="form-control" v-model="query.is_login">
                                <option value="2">Tất cả</option>
                                <option value="0">Chưa đăng nhập</option>
                                <option value="1">Đã đăng nhập</option>
                            </select>
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
                                :getData="getUserData"
                            />

                            <div class="card-body data-table table-responsive p-0">
                                <table class="table text-center table-hover table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width: 25px">
                                                <a href="/" @click="sortUserData($event, 'id_sort')">
                                                    ID
                                                    <i
                                                        class="id-icon fas"
                                                        v-bind:class="[
                                                            query.id_sort == 'asc' ? 'fa-arrow-up' : 'fa-arrow-down'
                                                        ]"
                                                    />
                                                </a>
                                            </th>
                                            <th style="width: 250px">Chức vụ</th>
                                            <th style="width: 250px">Họ tên</th>
                                            <th style="width: 250px">Số điện thoại</th>
                                            <th style="width: 250px">Email</th>
                                            <th style="width: 250px">Trạng thái đăng nhập</th>
                                            <th style="width: 250px">Ngày tạo</th>
                                            <th style="width: 100px"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data" v-if="dataList">
                                        <tr v-for="data, index in dataList.list">
                                            <td>{{ data.id }}</td>
                                            <td>{{ data.role_id == 0 ? 'Admin' : 'Người dùng' }}</td>
                                            <td>{{ data.name }}</td>
                                            <td>{{ data.phone }}</td>
                                            <td>{{ data.email }}</td>
                                            <td>
                                                <span 
                                                    class="badge" 
                                                    v-bind:class="[
                                                        data.is_login == 1 ? 'alert-success' : 'alert-secondary'
                                                    ]"
                                                >
                                                    {{ data.is_login == 1 ? 'Đã đăng nhập' : 'Chưa đăng nhập' }}
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
                                                        <a class="action-detail-btn" v-bind:class="{ 'disabled' : $store.state.auth.user.id == data.id }" @click="deleteData($event, data.id)">
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

        <UserInformation
            v-if="isForm"

            :closeForm="closeForm"
            :userData="data"
            :getUserData="getUserData"
        />
    </div>
</template>

<script>
    import TablePagination from '../../commons/pagination/TablePagination.vue';
    import UserInformation from './UserInformation.vue';

    export default {
        name: "User",
        components: {
            TablePagination,
            UserInformation
        },
        data() {
            return {
                dataList: null,
                query: {
                    limit: 15,
                    page: 1,
                    id_sort: "desc",
                    information: "",
                    is_login: 2,
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

            this.getUserData();
        },
        methods: {
            async getUserData() {
                this.$helper.setPageLoading(true);
                await this.$store.dispatch("getUsers", {
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

                this.getUserData();
            },

            sortUserData(e, queryParam) {
                e.preventDefault();

                if (this.query[queryParam] == "desc") {
                    this.query[queryParam] = "asc";
                } else {
                    this.query[queryParam] = "desc";
                }

                this.$helper.pushQueryUrl(this.query);
                this.getUserData();
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

                if (this.$store.state.auth.user.id != id) {
                    var alertMessage = 'Bạn muốn xóa tài khoản này?';
                    var successMessage = 'Xóa thành công';
                    if (this.query.is_deleted == 1) {
                        alertMessage = 'Bạn muốn khôi phục tài khoản này?';
                        successMessage = 'Khôi phục thành công';
                    }

                    if (confirm(alertMessage)) {
                        this.$helper.setPageLoading(true);
                        await this.$store.dispatch("deleteUser", {
                            id: id,
                            error: this.formDataError
                        })
                        .then(res => {
                            this.$helper.setNotification(1, successMessage);
                        })
                        .catch(err => {

                        });

                        this.getUserData();
                    }
                }
            }
        }
    }
</script>
