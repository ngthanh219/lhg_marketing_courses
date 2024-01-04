<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a class="brand-link">
            <div class="brand-image img-circle elevation-3">DMS</div>
            <span class="brand-text font-weight-light">Quản trị hệ thống</span>
        </a>
        <div class="sidebar" style="overflow-y: auto;">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-header">Quản lý hệ thống</li>
                    <li class="nav-item">
                        <router-link to="/admin/users" class="nav-link">
                            <i class="nav-icon far fa-user"></i>
                            <p>Quản lý tài khoản</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/courses" class="nav-link">
                            <i class="nav-icon fa fa-book"></i>
                            <p>Quản lý khóa học</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/course-sections" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>Quản lý phần học</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/video-object" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>Quản lý kho video</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/videos" class="nav-link">
                            <i class="nav-icon fa fa-video"></i>
                            <p>Quản lý thông tin video</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/books" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Quản lý sách</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/posts" class="nav-link">
                            <i class="nav-icon far fa-newspaper"></i>
                            <p>Quản lý bài viết</p>
                        </router-link>
                    </li>
                    <div class="clear-br"></div>
                    <li class="nav-header">Thông tin người dùng</li>
                    <li class="nav-item">
                        <router-link to="/admin/course-users" class="nav-link">
                            <i class="nav-icon far fa-plus-square"></i>
                            <p>Khóa học</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/book-users" class="nav-link">
                            <i class="nav-icon fas fa-book-medical"></i>
                            <p>Sách</p>
                        </router-link>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>

<script>
    export default {
        name: 'Menu'
    }
</script>
