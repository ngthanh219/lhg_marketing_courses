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
                                            {{ isShowVideo ? 'Video link: ' + videoData.key : 'Upload video mới' }}
                                        </h3>
                                    </div>
                                    <div class="card-body" v-if="!isShowVideo">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Video</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="exampleInputFile" @change="handleSource" :disabled="isStartUpload ? true : false">
                                                    <label class="custom-file-label" for="exampleInputFile">{{ videoFile ? videoFile.name : 'Chọn file' }}</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span
                                                        class="input-group-text cursor-pointer" 
                                                        v-bind:class="{ 'disabled' : !videoFile || isStartUpload }"
                                                        v-on="isUploadError ? { click: reloadUpload } : { click: createMultipartUpload}"
                                                    >
                                                        Tải {{ isUploadError ? 'lại' : 'lên' }}
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
                                                Đường dẫn: 
                                                <a class="underline">
                                                    {{ multipartUploadArgs.key }}
                                                </a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body text-center" v-if="isShowVideo && !isLoadVideo">
                                        <video width="640" height="360" controls id="myVideo">
                                            <source :src="videoLink" type="video/mp4" />
                                        </video>
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
            getVideoObject: Function,
            isShowVideo: Boolean,
            videoData: Object
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
                    key: null,
                    uploadId: null
                },
                videoLink: null,
                isLoadVideo: false,
                videoBlob: [],
            }
        },
        mounted() {
            this.$helper.scrollTop()

            setTimeout(() => {
                this.isTransitionActive = true;
                this.showVideo();
            }, 200);
        },
        updated() {
            // var self = this;
            // setInterval(function() {
            //     if (self.videoLink) {
            //         if (document.getElementById('myVideo')) {
            //             document.getElementById('myVideo').addEventListener('contextmenu', function (e) {
            //                 e.preventDefault();
            //             });
            //             document.getElementById('myVideo').controlsList.add("nodownload");
            //         }
            //     }
            // }, 500);
        },
        methods: {
            handleVideoLink(length) {
                if (this.videoBlob.length < length) {
                    this.handleVideoLink(length);
                } else {
                    var videoBlob = new Blob(this.videoBlob, { type: 'video/mp4' });
                    this.videoLink = URL.createObjectURL(videoBlob);
                    setTimeout(() => {
                        this.isLoadVideo = false;
                        this.$helper.setPageLoading(false);
                    }, 5000);
                }
            },

            concatFile(data) {
                var length = data.length;

                for (let param in data) {
                    let chunkFilePath = data[param];

                    this.$store.dispatch("getChunkFile", {
                        query: this.$helper.getQueryString({
                            path: chunkFilePath,
                        }),
                        error: {}
                    })
                    .then(res => {
                        this.videoBlob[res.number] = res.data;
                        console.log('loading ... ' + parseInt((this.videoBlob.length * 100) / length) + '%');
                        this.handleVideoLink(length);
                    })
                    .catch(err => {
                    });
                }
            },

            async showVideo() {
                if (this.isShowVideo) {
                    this.isLoadVideo = true;
                    // this.$helper.setPageLoading(true);
                    // await this.$store.dispatch("showVideoObject", {
                    //     query: this.$helper.getQueryString({
                    //         key: this.videoData.key,
                    //     }),
                    //     error: {}
                    // })
                    // .then(res => {
                    //     // this.concatFile(res.data);
                    //     this.videoLink = URL.createObjectURL(new Blob([res], { type: 'video/mp4' }));
                    // })
                    // .catch(err => {
                    // });
                    
                    // this.$helper.setPageLoading(false);
                    // this.isLoadVideo = false;

                    var link = 'https://kinhdoanhthucchien.edu.vn/storage/' + this.videoData.key;

                    fetch(link)
                    .then(response => response.blob())
                    .then(blob => {
                        this.videoLink = URL.createObjectURL(blob);
                        this.isLoadVideo = false;
                    })
                    .catch(error => {
                        console.error('Lỗi khi tải video: ', error);
                        this.isLoadVideo = false;
                    });
                }
            },

            async closeFormComponent(e) {
                e.preventDefault();

                if (this.videoFile && this.isStartUpload && this.multipartUploadArgs.key) {
                    if (this.progressUploading < 100) {
                        if (confirm('File đang được tải lên, bạn có chắc chắn muốn hủy')) {
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
                        }
                    }
                }

                this.isTransitionActive = false;
                setTimeout(() => {
                    this.closeForm(e);
                }, 400);
            },

            handleSource(e) {
                if (!this.isStartUpload) {
                    this.videoFile = e.target.files[0];
                    if (this.videoFile.name.split('.').pop() != 'mp4') {
                        this.$helper.setNotification(0, 'File bạn chọn không phải video');
                        this.videoFile = '';
                    } else {
                        this.progressUploading = 0;
                    }
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

                        // console.log(this.chunks[0]);
                        // console.log(typeof this.chunks[0]);

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
                            this.progressUploading = Math.floor((index + 1) / this.chunks.length * 100);
                            if (this.progressUploading == 100) {
                                this.progressUploading = 99;
                            }

                            this.signMultipartUpload(index + 1);
                        })
                        .catch(err => {
                            this.isStartUpload = false;
                            this.isUploadError = true;
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
                            })
                            .catch(err => {
                                this.$helper.setPageLoading(false);
                            });
                        });
                    } else {
                        this.$store.dispatch("completeMultipartUpload", {
                            request: this.$helper.appendFormData({
                                key: this.multipartUploadArgs.key,
                                upload_id: this.multipartUploadArgs.uploadId,
                            }),
                            error: {}
                        })
                        .then(res => {
                            this.progressUploading = 100;
                            this.chunks = [];
                            this.multipartUploadArgs.uploadId = null;

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
