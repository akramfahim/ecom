<template>
    <div>
        <!-- Navbar -->
        <topNavbar v-if="isLoggedin"></topNavbar>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <asideComponent v-if="isLoggedin"></asideComponent>
        <!-- /.Main Sidebar Container --> 

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content p-3">
                <div class="container-fluid">

                    <router-view></router-view>
            
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Main Footer -->
        <footerComponent v-if="isLoggedin"></footerComponent>
        <!-- /.Main Footer -->
        
    </div>
    <!-- ./wrapper -->
</template>

<script>
import topNavbar from './admin/topNavbar'
import asideComponent from './admin/asideComponent'
import footerComponent from './admin/footerComponent'
export default {
    data(){
        return {
            isLoggedin: false
        }
    },
    components:{
        topNavbar,
        asideComponent,
        footerComponent
    }
}
</script>