<template>
    <div class="popup-component" v-bind:class="{ 'transition-active': !isTransitionActive }">
        <div class="pc-form" v-bind:class="{ 'transition-active': isTransitionActive }">
            <div class="content">
                <div class="container-fluid" style="width: 80%">
                    <div class="row">
                        <div class="col-md-12">
                            <form>
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            Upload video mới
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Video</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="exampleInputFile" @change="handleSource">
                                                    <label class="custom-file-label" for="exampleInputFile">{{ videoFile ? videoFile.name : 'Chọn file' }}</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span
                                                        class="input-group-text cursor-pointer" 
                                                        v-bind:class="{ 'disabled' : !videoFile || isStartUpload }"
                                                        v-on="isUploadError ? { click: reloadUpload } : { click: createMultipartUpload}"
                                                    >
                                                        {{ isUploadError ? 'Tải lại' : 'Tải lên' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input 
                                                    class="custom-control-input" 
                                                    type="checkbox" 
                                                    id="customCheckbox2" 
                                                    v-model="isFileNameRandom"
                                                    :disabled="isStartUpload ? true : false"
                                                >
                                                <label for="customCheckbox2" class="custom-control-label cursor-pointer">Random tên file</label>
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="videoFile && isStartUpload">
                                            <label>
                                                {{ progressUploading > 0 && progressUploading < 100 ? 'Đang tải: ' : '' }}
                                                {{ progressUploading == 100 ? 'Đã tải: ' : '' }}
                                                {{ progressUploading }}%
                                            </label>
                                            <div class="progress progress-xs progress-striped active">
                                                <div class="progress-bar" v-bind:class="[
                                                    progressUploading < 100 ? [
                                                        !isUploadError ? 'bg-primary' : 'bg-danger'
                                                    ] : 'bg-success'
                                                ]" :style="'width: ' + progressUploading + '%'"></div>
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="progressUploading == 100">
                                            <label>
                                                Link video: 
                                                <a :href="multipartUploadArgs.link" target="_blank">
                                                    {{ this.$env.s3Url + multipartUploadArgs.key }}
                                                </a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a class="btn btn-danger" @click="closeFormComponent">Quay lại</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "VideoObjectInformation",
        components: {
        },
        props: {
            closeForm: Function,
            getVideoObject: Function
        },
        data() {
            return {
                isTransitionActive: false,
                videoFile: '',
                chunks: [],
                progressUploading: 0,
                isStartUpload: false,
                isUploadError: false,
                isFileNameRandom: true,
                multipartUploadArgs: {
                    link: null,
                    key: null,
                    uploadId: null,
                    fileParts: [],
                    data: null
                }
            }
        },
        mounted() {
            this.$helper.scrollTop()

            setTimeout(() => {
                this.isTransitionActive = true;
            }, 200);
        },
        methods: {
            async closeFormComponent(e) {
                e.preventDefault();

                if (this.videoFile && this.isStartUpload) {
                    if (confirm('File đang được tải lên, bạn có chắc chắn muốn hủy')) {
                        if (this.multipartUploadArgs.key) {
                            this.isStartUpload = false;
                            this.$helper.setPageLoading(true);

                            this.$store.dispatch("abortMultipartUpload", {
                                request: this.$helper.appendFormData({
                                    key: this.multipartUploadArgs.key,
                                    upload_id: this.multipartUploadArgs.uploadId
                                }),
                                error: {}
                            })
                            .then(res => {
                                this.$helper.setNotification(1, 'Đã hủy video');
                                this.$helper.setPageLoading(false);
                                this.isTransitionActive = false;
                                setTimeout(() => {
                                    this.closeForm(e);
                                }, 400);
                            })
                            .catch(err => {
                                this.$helper.setPageLoading(false);
                            });
                        } else {
                            this.isTransitionActive = false;
                            setTimeout(() => {
                                this.closeForm(e);
                            }, 400);
                        }
                    }
                } else {
                    this.isTransitionActive = false;
                    setTimeout(() => {
                        this.closeForm(e);
                    }, 400);
                }
            },

            handleSource(e) {
                if (!this.isStartUpload) {
                    this.videoFile = e.target.files[0];
                    this.progressUploading = 0;
                }
            },

            async reloadUpload() {
                this.chunks = [];
                this.progressUploading = 0;
                this.isStartUpload = false;
                this.isUploadError = false;
                this.multipartUploadArgs.link = null;
                this.multipartUploadArgs.key = null;
                this.multipartUploadArgs.uploadId = null;
                this.multipartUploadArgs.fileParts = [];
                this.multipartUploadArgs.data = null;

                await this.createMultipartUpload();
            },

            async createMultipartUpload() {
                if (this.videoFile && !this.isStartUpload) {
                    this.isStartUpload = true;
                    const request = {};
                    if (!this.isFileNameRandom) {
                        request.file_name = this.videoFile.name;
                    }

                    await this.$store.dispatch("createMultipartUpload", {
                        request: this.$helper.appendFormData(request),
                        error: {}
                    }).then(res => {
                        this.multipartUploadArgs.key = res.data.key;
                        this.multipartUploadArgs.uploadId = res.data.upload_id;
                    })
                    .catch(err => {
                        this.isStartUpload = false;
                        this.isUploadError = true;
                    });

                    if (this.isStartUpload) {
                        const chunkSize = 5 * 1024 * 1024;
                        for (let i = 0; i < this.videoFile.size; i += chunkSize) {
                            const chunk = this.videoFile.slice(i, i + chunkSize);
                            this.chunks.push(chunk);
                        }

                        this.signMultipartUpload(0);
                    }
                }
            },

            async signMultipartUpload(index) {
                if (this.isStartUpload) {
                    if (index < this.chunks.length) {
                        this.$store.dispatch("signMultipartUpload", {
                            request: this.$helper.appendFormData({
                                key: this.multipartUploadArgs.key,
                                upload_id: this.multipartUploadArgs.uploadId,
                                part_number: index,
                                file: this.chunks[index],
                            }),
                            error: {
                                message: ''
                            }
                        })
                        .then(res => {
                            this.multipartUploadArgs.fileParts.push(res.data);
                            this.progressUploading = Math.floor((index + 1) / this.chunks.length * 100);
                            if (this.progressUploading == 100) {
                                this.progressUploading = 99;
                            }

                            this.signMultipartUpload(index + 1);
                        })
                        .catch(err => {
                            this.isStartUpload = false;
                            this.isUploadError = true;
                        });
                    } else {
                        this.$store.dispatch("completeMultipartUpload", {
                            request: this.$helper.appendFormData({
                                key: this.multipartUploadArgs.key,
                                upload_id: this.multipartUploadArgs.uploadId,
                                file_parts: JSON.stringify(this.multipartUploadArgs.fileParts),
                            }),
                            error: {}
                        })
                        .then(res => {
                            this.videoFile = '';
                            this.isStartUpload = false;
                            this.multipartUploadArgs.link = res.data;
                            this.progressUploading = 100;
                            this.chunks = [];
                            this.multipartUploadArgs.uploadId = null;
                            this.multipartUploadArgs.fileParts = [];
                            this.multipartUploadArgs.data = null;

                            this.getVideoObject();
                            this.$helper.setNotification(1, 'Tải video lên thành công');
                        })
                        .catch(err => {
                            this.isStartUpload = false;
                            this.isUploadError = true;
                        });
                    }
                }
            },
        }
    }
</script>
