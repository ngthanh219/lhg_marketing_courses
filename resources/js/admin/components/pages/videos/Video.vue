<template>
    <div class="content-wrapper page-component">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <div class="col-sm-6">
                            <a href="/" class="btn btn-sm btn-primary" @click="openForm">
                                <i class="id-icon fas fa-plus mr-2"></i>Thêm mới
                            </a>
                        </div>
                        <span v-if="dataList">
                            <div v-if="dataList.course_name">
                                <b>Khóa học: </b>
                                <span class="underline">{{ dataList.course_name }}</span>
                            </div>
                        </span>
                        <span v-if="dataList">
                            <div v-if="dataList.course_section_name">
                                <b>Phần: </b> 
                                <span class="underline sm">{{ dataList.course_section_name }}</span> - 
                                <router-link to="/admin/videos" class="underline oblique" @click="clearFilter($event, 'course_section_id')">
                                    clear
                                </router-link>
                            </div>
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                Trang chủ
                            </li>
                            <li class="breadcrumb-item active">
                                Danh sách video
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group input-group-sm">
                            <label>Nhập mô tả</label>
                            <input type="text" class="form-control" placeholder="Mô tả" v-model="query.description">
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
                            <a href="/" class="btn btn-primary" @click="filter">Lọc</a>
                        </div>
                    </div>
                </div>
                <div class="row">
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
                                :getData="getVideoData"
                            />

                            <div class="card-body data-table table-responsive p-0">
                                <table class="table text-center table-hover table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width: 25px">
                                                <a href="/" @click="sortVideoData($event, 'id_sort')">
                                                    ID
                                                    <i
                                                        class="id-icon fas"
                                                        v-bind:class="[
                                                            query.id_sort == 'asc' ? 'fa-arrow-up' : 'fa-arrow-down'
                                                        ]"
                                                    />
                                                </a>
                                            </th>
                                            <th style="width: 500px">Mô tả</th>
                                            <th style="width: 150px">Link video</th>
                                            <th style="width: 150px">Thời lượng (h:m:s)</th>
                                            <th style="width: 150px">Trạng thái</th>
                                            <th style="width: 150px">Ngày tạo</th>
                                            <th style="width: 100px"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data" v-if="dataList">
                                        <tr v-for="data, index in dataList.list">
                                            <td>{{ data.id }}</td>
                                            <td>{{ data.description }}</td>
                                            <td>
                                                <a class="underline" :href="data.source_url" target="_blank">Xem</a>
                                            </td>
                                            <td>{{ this.$helper.formatDuration(data.duration) }}</td>
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

        <VideoInformation
            v-if="isForm"

            :closeForm="closeForm"
            :videoData="data"
            :getVideoData="getVideoData"
        />
    </div>
</template>

<script>
    import TablePagination from '../../commons/pagination/TablePagination.vue';
    import VideoInformation from './VideoInformation.vue';

    export default {
        name: "Video",
        components: { 
            TablePagination,
            VideoInformation
        },
        data() {
            return {
                dataList: null,
                query: {
                    limit: 15,
                    page: 1,
                    id_sort: "desc",
                    description: "",
                    is_show: 2,
                    course_section_id: null,
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

            this.getVideoData();
        },
        methods: {
            async getVideoData() {
                this.$helper.setPageLoading(true);
                await this.$store.dispatch("getVideos", {
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

                this.getVideoData();
            },

            clearFilter(e, param) {
                e.preventDefault();

                this.query[param] = null;
                this.getVideoData();
            },

            sortVideoData(e, queryParam) {
                e.preventDefault();

                if (this.query[queryParam] == "desc") {
                    this.query[queryParam] = "asc";
                } else {
                    this.query[queryParam] = "desc";
                }

                this.$helper.pushQueryUrl(this.query);
                this.getVideoData();
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

                var alertMessage = 'Bạn muốn xóa video này?';
                var successMessage = 'Xóa thành công';
                if (this.query.is_deleted == 1) {
                    alertMessage = 'Bạn muốn khôi phục video này?';
                    successMessage = 'Khôi phục thành công';
                }

                if (confirm(alertMessage)) {
                    this.$helper.setPageLoading(true);
                    await this.$store.dispatch("deleteVideo", {
                        id: id,
                        error: this.formDataError
                    })
                    .then(res => {
                        this.$helper.setNotification(1, successMessage);
                    })
                    .catch(err => {

                    });

                    this.getVideoData();
                }
            }
        }
    }
</script>
