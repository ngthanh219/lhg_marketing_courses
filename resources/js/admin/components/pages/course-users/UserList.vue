<template>
    <div class="page-component modal-list">
        <div class="content-header">
            <div class="form-group input-group-sm">
                <a href="/" class="btn btn-sm btn-primary" @click="closeModal">Quay lại</a>
            </div>
            <div class="container-fluid">
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
                                            <th style="width: 25px"></th>
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
                                            <th style="width: 250px">Họ tên</th>
                                            <th style="width: 250px">Số điện thoại</th>
                                            <th style="width: 250px">Email</th>
                                            <th style="width: 250px">Trạng thái đăng nhập</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data" v-if="dataList">
                                        <tr v-for="data, index in dataList.list">
                                            <td>
                                                <a class="btn btn-sm btn-danger" v-if="data.id === userId">Đang chọn</a>
                                                <a class="btn btn-sm btn-outline-primary" @click="selectData($event, data.id, data.email)" v-else>Chọn</a>
                                            </td>
                                            <td>{{ data.id }}</td>
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
    </div>
</template>

<script>
    import TablePagination from '../../commons/pagination/TablePagination.vue';

    export default {
        name: "UserList",
        components: { 
            TablePagination
        },
        props: {
            closeModalList: Function,
            selectUserData: Function,
            userId: Number
        },
        data() {
            return {
                dataList: null,
                query: {
                    limit: 15,
                    page: 1,
                    id_sort: "desc",
                    name: "",
                    is_show: 2,
                    is_deleted: 0,
                    is_login: 2,
                },
                formDataError: {
                    message: ""
                }
            };
        },
        mounted() {
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

                this.getUserData();
            },

            closeModal(e) {
                e.preventDefault();

                this.closeModalList('user');
            },

            selectData(e, id, name) {
                e.preventDefault();

                this.selectUserData(id, name);
            }
        }
    }
</script>
