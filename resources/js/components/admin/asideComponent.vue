<template>
    <div>
        <aside class="main-sidebar sidebar-dark-primay elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Ecom Panel</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/img/admin-pp.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ $store.state.loggedInUser.fullName}} | {{ $store.state.loggedInUser.userType }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <router-link to="/" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="categories" class="nav-link">
                                <i class="nav-icon fas fa-certificate"></i>
                                <p>
                                    Category
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="products" class="nav-link">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>
                                    Product
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="orders" class="nav-link">
                                <i class="nav-icon fas fa-cart-plus"></i>
                                <p>
                                    Order
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="customers" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Customers
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="isAdmin">
                            <router-link to="adminusers" class="nav-link">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    Admin Users
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <a href="/logout" class="nav-link">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

    </div>
</template>
<script>
export default {
    data(){
        return {
            userType : '',
            isAdmin : false,
            isEditor: false,
            isModerator: false
        }
    },
    created(){
        //console.log(this.user)
        this.userType = this.$store.state.loggedInUser.userType
        
        if(this.userType === 'admin'){
            this.isAdmin = true
        }else if(this.userType === 'editor'){
            this.isEditor = true
        }else{
            this.isModerator = true
        }
    }
}
</script>