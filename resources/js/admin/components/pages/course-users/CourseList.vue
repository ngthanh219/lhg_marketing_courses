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
                            <label>Tên khóa học</label>
                            <input type="text" class="form-control" placeholder="Tên khóa học" v-model="query.name">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group input-group-sm">
                            <label>Trạng thái</label>
                            <select class="form-control" v-model="query.is_show">
                                <option value="2">Tất cả</option>
                                <option value="0">Đang hiển thị</option>
                                <option value="1">Đã ẩn</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-group input-group-sm">
                            <a href="/" class="btn btn-sm btn-primary" @click="filter">Lọc</a>
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
                                :getData="getCourseData"
                            />

                            <div class="card-body data-table table-responsive p-0">
                                <table class="table text-center table-hover table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width: 25px"></th>
                                            <th style="width: 25px">
                                                <a href="/" @click="sortCourseData($event, 'id_sort')">
                                                    ID
                                                    <i
                                                        class="id-icon fas"
                                                        v-bind:class="[
                                                            query.id_sort == 'asc' ? 'fa-arrow-up' : 'fa-arrow-down'
                                                        ]"
                                                    />
                                                </a>
                                            </th>
                                            <th style="width: 250px">Tên khóa học</th>
                                            <th style="width: 250px">Giá</th>
                                            <th style="width: 250px">Giảm giá</th>
                                            <th style="width: 250px">Giá khuyến mãi</th>
                                            <th style="width: 250px">Trạng thái hiển thị</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data" v-if="dataList">
                                        <tr v-for="data, index in dataList.list">
                                            <td>
                                                <a class="btn btn-sm btn-danger" v-if="data.id === courseId">Đang chọn</a>
                                                <a class="btn btn-sm btn-outline-primary" @click="selectData($event, data.id, data.name)" v-else>Chọn</a>
                                            </td>
                                            <td>{{ data.id }}</td>
                                            <td>{{ data.name }}</td>
                                            <td>{{ data.price.toLocaleString() + 'đ' }}</td>
                                            <td>{{ data.discount }}%</td>
                                            <td>{{ data.discount_price.toLocaleString() + 'đ' }}</td>
                                            <td>
                                                <span 
                                                    class="badge" 
                                                    v-bind:class="[
                                                        data.is_show == 0 ? 'alert-success' : 'alert-secondary'
                                                    ]"
                                                >
                                                    {{ data.is_show == 0 ? 'Đang hiển thị' : 'Đã ẩn' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-if="dataList && dataList.list.length == 0">
                                        <tr>
                                            <td colspan="8">Không có dữ liệu</td>
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
        name: "CourseList",
        components: { 
            TablePagination
        },
        props: {
            closeModalList: Function,
            selectCourseData: Function,
            courseId: Number
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
                    is_deleted: 0
                },
                formDataError: {
                    message: ""
                }
            };
        },
        mounted() {
            this.getCourseData();
        },
        methods: {
            async getCourseData() {
                this.$helper.setPageLoading(true);
                await this.$store.dispatch("getCourses", {
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

                this.getCourseData();
            },

            sortCourseData(e, queryParam) {
                e.preventDefault();

                if (this.query[queryParam] == "desc") {
                    this.query[queryParam] = "asc";
                } else {
                    this.query[queryParam] = "desc";
                }

                this.getCourseData();
            },

            closeModal(e) {
                e.preventDefault();

                this.closeModalList('course');
            },

            selectData(e, id, name) {
                e.preventDefault();

                this.selectCourseData(id, name);
            }
        }
    }
</script>
