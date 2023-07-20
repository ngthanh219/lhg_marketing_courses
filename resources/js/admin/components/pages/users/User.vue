<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Quản lý tài khoản</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#">Trang chủ</a>
                            </li>
                            <li class="breadcrumb-item active">Quản lý người dùng</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group input-group-sm">
                            <label>Thông tin</label>
                            <input type="text" class="form-control" placeholder="Email, số điện thoại">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group input-group-sm">
                            <label>Trạng thái</label>
                            <select class="form-control">
                                <option value="0">Đang hoạt động</option>
                                <option value="1">Đã khóa</option>
                            </select>
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
                                <h3 class="card-title limit-offset">1/1200 dữ liệu</h3>
                                <div class="card-tools row">
                                    <div class="input-group input-group-sm data-filter page">
                                        <div class="label">Trang: </div>
                                        <input type="text" style="width: 10px;" class="form-control" value="1" placeholder="1">
                                    </div>
                                    <div class="input-group input-group-sm data-filter">
                                        <div class="label">Hiển thị: </div>
                                        <select class="form-control">
                                            <option value="10">15</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                    <div>
                                        <ul class="pagination pagination-sm float-right">
                                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body data-table table-responsive p-0">
                                <table class="table text-center table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width: 25px">
                                                <a href="" id="order-by-id">
                                                    User ID
                                                    <i class="id-icon fas fa-arrow-down"></i>
                                                </a>
                                            </th>
                                            <th style="width: 250px">Full name</th>
                                            <th style="width: 250px">Email</th>
                                            <th class="d-none user-agent">User agent</th>
                                            <th style="width: 250px">Wallet address</th>
                                            <th style="width: 250px">Stamina</th>
                                            <th style="width: 250px">
                                                <a href="" id="order-by-bape-coin">
                                                    Bape coin
                                                    <i class="bape-coin-icon fas fa-arrow-down"></i>
                                                </a>
                                            </th>
                                            <th style="width: 250px">
                                                <a href="" id="order-by-ape-coin">
                                                    Ape coin
                                                    <i class="ape-coin-icon fas fa-arrow-down"></i>
                                                </a>
                                            </th>
                                            <th style="width: 250px">
                                                <a href="" id="order-by-earn">
                                                    Earned
                                                    <i class="earn-icon fas fa-arrow-down"></i>
                                                </a>
    
                                            </th>
                                            <th>Status</th>
                                            <th style="width: 250px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-data"></tbody>
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
        name: 'User',
        data() {
            return {

            }
        }
    }
</script>
