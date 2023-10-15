<template>
    <div class="content-wrapper page-component">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <a href="/" class="btn btn-sm btn-primary" @click="openForm">
                            <i class="id-icon fas fa-plus mr-2"></i>Upload file
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                Trang chủ
                            </li>
                            <li class="breadcrumb-item active">
                                Kho video
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group input-group-sm">
                            <label>Video</label>
                            <input type="text" class="form-control" placeholder="Tìm kiếm theo link" v-model="searchKey">
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-group input-group-sm">
                            <a href="/" class="btn btn-primary mr-2" @click="filter">Lọc</a>
                            <a href="/" class="btn btn-primary" @click="refresh">Làm mới</a>
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
                            <div class="card-body data-table table-responsive p-0">
                                <table class="table text-center table-hover table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Link video</th>
                                            <th style="width: 100px"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data" v-if="dataList">
                                        <tr v-for="data, index in dataList" :id="'item-' + index" v-bind:class="{ 'active': idKey == 'item-' + index }">
                                            <td style="width: 25px">{{ index += 1 }}</td>
                                            <td>
                                                <a class="underline cursor-pointer" @click="showVideo($event, index - 1, dataList[index - 1])">{{ data.key }}</a>
                                            </td>
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
                                                        <a class="action-detail-btn" v-if="query.is_deleted == 0" @click="openForm($event, index, dataList[index])">
                                                            <i class="fas fa-eye"></i>
                                                            <div class="icon-wrap">Xem thông tin</div>
                                                        </a>
                                                        <a class="action-detail-btn" @click="deleteData($event, data.key)">
                                                            <i class="fas fa-trash" />
                                                            <div class="icon-wrap">
                                                                Xóa
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-if="dataList && dataList.length == 0">
                                        <tr>
                                            <td colspan="4">Không có dữ liệu</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <VideoObjectInformation
            v-if="isForm"

            :closeForm="closeForm"
            :getVideoObject="getVideoObject"
            :isShowVideo="isShowVideo"
            :videoData="data"
        />
    </div>
</template>

<script>
    import VideoObjectInformation from './VideoObjectInformation.vue';

    export default {
        name: "VideoObject",
        components: { 
            VideoObjectInformation
        },
        data() {
            return {
                dataList: null,
                query: {
                    path: "",
                    last_modified_sort: 'desc'
                },
                formDataError: {
                    message: ""
                },
                isForm: false,
                isShowVideo: false,
                searchKey: '',
                idKey: '',
                data: null
            };
        },
        mounted() {
            this.$helper.getCurrentQuery(this.query);

            this.getVideoObject();
        },
        methods: {
            async getVideoObject() {
                this.$helper.setPageLoading(true);
                await this.$store.dispatch("getVideoObject", {
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

            refresh(e) {
                e.preventDefault();

                this.searchKey = '';
                this.idKey = '';
                this.getVideoObject();
            },

            filter(e) {
                e.preventDefault();

                for (var i = 0; i < this.dataList.length; i++) {
                    if (this.dataList[i].key == this.searchKey) {
                        var key = 'item-' + i;
                        const targetElement = document.getElementById(key);
                        targetElement.scrollIntoView({ behavior: "smooth", block: "center" });
                        this.idKey = key;

                        break;
                    }
                }
            },

            sortVideoObjectData(e, queryParam) {
                e.preventDefault();

                if (this.query[queryParam] == "desc") {
                    this.query[queryParam] = "asc";
                } else {
                    this.query[queryParam] = "desc";
                }

                this.$helper.pushQueryUrl(this.query);
                this.getVideoObject();
            },

            showVideo(e, index, data) {
                e.preventDefault();

                this.isShowVideo = true;
                this.openForm(e, index, data);
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
                this.query.path = '';
            },

            closeForm(e) {
                e.preventDefault();

                this.data = null;
                this.isForm = false;
                this.isShowVideo = false;
            },

            async deleteData(e, key) {
                e.preventDefault();

                var alertMessage = 'Bạn muốn xóa video này?';
                var successMessage = 'Xóa thành công';

                if (confirm(alertMessage)) {
                    this.$helper.setPageLoading(true);
                    await this.$store.dispatch("deleteVideoObject", {
                        request: this.$helper.appendFormData({
                            key: key,
                        }),
                        error: this.formDataError
                    })
                    .then(res => {
                        this.$helper.setNotification(1, successMessage);
                    })
                    .catch(err => {

                    });

                    this.getVideoObject();
                }
            }
        }
    }
</script>
