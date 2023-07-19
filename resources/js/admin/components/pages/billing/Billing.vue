<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Quản lý hóa đơn</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#">Trang chủ</a>
                            </li>
                            <li class="breadcrumb-item active">Quản lý hóa đơn</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Số lượng hiển thị</label>
                            <input type="number" class="form-control" min="15" placeholder="15" value="15">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Trang</label>
                            <input type="number" class="form-control offset" min="1" value="1">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <a id="filter-action" class="btn btn-primary">Filter</a>
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
                            <div class="card-header">
                                <h3 class="card-title limit-offset"></h3>
                                <div class="text-right">
                                    <a href="" class="btn btn-outline-dark btn-sm" id="paginate-left">
                                        <i class="fas fa-angle-left left"></i>
                                    </a>
                                    <a href="" class="btn btn-outline-dark btn-sm" id="paginate-right">
                                        <i class="fas fa-angle-right right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0" style="height: 680px">
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
        name: 'Billing',
        data() {
            return {

            }
        }
    }
</script>
