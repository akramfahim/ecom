<template>
    <div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    Admin User List
                </h2>

                <div class="card-tools">
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addNewModal">
                        <i class="fas fa-plus"></i> 
                        Create Admin User
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>111</td>
                            <td>Akram Fahim</td>
                            <td>akram@gmail.com</td>
                            <td>Admin</td>
                            <td>27th Jul 2020</td>
                            <td>
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
        </div>

        <!-- Add New Category Modal -->
        <div class="modal fade" id="addNewModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Admin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <input type="text" v-model="data.fullName" placeholder="Full Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="email" v-model="data.email" placeholder="Email Address" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="password" v-model="data.password" placeholder="Password" class="form-control">
                            </div>
                            <div class="form-group">
                                <select class="form-control" v-model="data.userType">
                                    <option value="">Select Admin Type</option>
                                    <option value="admin">Admin</option>
                                    <option value="editor">Editor</option>
                                    <option value="moderator">Moderator</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="createAdminUser">
                            Create Now
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Category Modal -->
        <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Admin User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" id="categoryName" placeholder="Category Name">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">
                            Update Now
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return {
            data : {
                fullName: '',
                email: '',
                password: '',
                userType: ''
            }
        }
    },
    methods:{
        async createAdminUser(){
            if(this.data.fullName.trim() == '') return this.error('Full Name is Required')
            if(this.data.email.trim() == '') return this.error('Email is Required')
            if(this.data.password.trim() == '') return this.error('Password is Required')
            if(this.data.userType.trim() == '') return this.error('Admin Type is Required')

            const res = await this.callApi('post','/app/add_adminuser',this.data)
            if(res.status == 201){
                //this.products.unshift(res.data.product)
                $('#addNewModal').modal('hide')
                this.success('Product Added Successfully');
                
                this.data.fullName='',
                this.data.email='',
                this.data.password='',
                this.data.productImage='',
                this.data.productImage=''

            }else if(res.status == 422){
                if(res.data.errors.fullName){
                    this.error(res.data.errors.fullName[0])
                }else if(res.data.errors.email){
                    this.error(res.data.errors.email[0])
                }else if(res.data.errors.password){
                    this.error(res.data.errors.password[0])
                }else if(res.data.errors.userType){
                    this.error(res.data.errors.productImage[0])
                }
            }else{
                this.swr()
            }

        }
    }


}
</script>