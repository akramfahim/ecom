<template>
    <div>
        <!-- Navbar -->
        <topNavbar></topNavbar>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <asideComponent></asideComponent>
        <!-- /.Main Sidebar Container --> 

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">

                    <router-view></router-view>
            
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Main Footer -->
        <footerComponent></footerComponent>
        <!-- /.Main Footer -->
        
    </div>
    <!-- ./wrapper -->
</template>

<script>
import topNavbar from './admin/topNavbar'
import asideComponent from './admin/asideComponent'
import footerComponent from './admin/footerComponent'
export default {
    components:{
        topNavbar,
        asideComponent,
        footerComponent
    }
}
</script>