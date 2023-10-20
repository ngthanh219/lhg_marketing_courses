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
                                            <th style="width: 50px"></th>
                                            <th>STT</th>
                                            <th>Link video</th>
                                            <th>
                                                <a href="/" @click="sortVideoObjectData($event, 'last_modified_sort')">
                                                    Ngày tạo
                                                    <i
                                                        class="id-icon fas"
                                                        v-bind:class="[
                                                            query.last_modified_sort == 'asc' ? 'fa-arrow-up' : 'fa-arrow-down'
                                                        ]"
                                                    />
                                                </a>
                                            </th>
                                            <th>Thời gian</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data" v-if="dataList">
                                        <tr v-for="data, index in dataList" :id="'item-' + index" v-bind:class="{ 'active': idKey == 'item-' + index }">
                                            <td>
                                                <a class="btn btn-sm btn-danger" v-if="data.Key === source">Đang chọn</a>
                                                <a class="btn btn-sm btn-outline-primary" @click="selectData($event, data.Key, data.Duration)" v-else>Chọn</a>
                                            </td>
                                            <td>{{ index += 1 }}</td>
                                            <td>
                                                <a class="underline cursor-pointer" @click="showVideo($event, data.Key)">{{ data.Key }}</a>
                                            </td>
                                            <td>{{ $helper.formatDuration(data.Duration) }}</td>
                                            <td>{{ data.LastModified }}</td>
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
    </div>
</template>

<script>
    export default {
        name: "VideoObjectList",
        props: {
            closeModalList: Function,
            selectSourceData: Function,
            source: String
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
                searchKey: '',
                idKey: ''
            };
        },
        mounted() {
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
                    if (typeof (res.data) !== 'string') {
                        this.dataList = res.data;
                    } else {
                        window.open(res.data, '_blank');
                    }
                })
                .catch(err => {
                });
                this.$helper.setPageLoading(false);
            },

            refresh(e) {
                e.preventDefault();

                this.getVideoObject();
            },

            filter(e) {
                e.preventDefault();

                for (var i = 0; i < this.dataList.length; i++) {
                    if (this.dataList[i].Key == this.searchKey) {
                        var key = 'item-' + i;
                        const targetElement = document.getElementById(key);
                        targetElement.scrollIntoView({ behavior: "smooth", block: "center" });
                        this.idKey = key;

                        break;
                    }
                }
            },

            showVideo(e, path) {
                e.preventDefault();

                this.query.path = path;
                this.getVideoObject();
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

            closeModal(e) {
                e.preventDefault();

                this.closeModalList();
            },

            selectData(e, key, duration) {
                e.preventDefault();

                this.selectSourceData(key, duration);
            }
        }
    }
</script>
