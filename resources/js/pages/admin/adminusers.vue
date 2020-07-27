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
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user,index) in adminusers" :key="index" v-if="adminusers.length">
                            <td>{{index}}</td>
                            <td>{{ user.fullName}}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.userType}}</td>
                            <td>
                                <button class="btn btn-sm" :class="(user.status)==0 ? 'btn-danger' : 'btn-success' ">
                                    {{ (user.status ==0) ? 'Inactive' : 'Active' }}
                                </button>
                            </td>
                            <td>{{ user.created_at }}</td>
                            <td>
                                    <button class="btn btn-primary btn-sm" @click="showEditModal(user,index)">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" @click="deleteAdminUser(user,index)">
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
                            <div class="form-group">
                                <select class="form-control" v-model="data.status">
                                    <option value="">Select Admin Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
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
                                <input type="text" v-model="editData.fullName" placeholder="Full Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="email" v-model="editData.email" placeholder="Email Address" class="form-control">
                            </div>
                            <div class="form-group">
                                <select class="form-control" v-model="editData.userType">
                                    <option value="admin">Admin</option>
                                    <option value="editor">Editor</option>
                                    <option value="moderator">Moderator</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" v-model="editData.status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="editAdminUser" :disabled="isUpdating" :loading="isUpdating">
                            {{ isUpdating ? 'Updating...' : 'Update Now'}}
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
                userType: '',
                status: ''
            },
            isAdding: false,
            adminusers : [],

            editData: {
                fullName: '',
                email: '',
                userType: '',
                status: ''
            },
            index: -1,
            isUpdating : false
        }
    },
    methods: {
        async loadAdminUsers(){
            const res = await this.callApi('get','/app/all_adminusers')

            this.adminusers = res.data
        },
        async createAdminUser(){
            if(this.data.fullName.trim() == '') return this.error('Full Name is Required')
            if(this.data.email.trim() == '') return this.error('Email is Required')
            if(this.data.password.trim() == '') return this.error('Password is Required')
            if(this.data.userType.trim() == '') return this.error('Admin Type is Required')

            const res = await this.callApi('post','/app/add_adminuser',this.data)
            if(res.status == 201){
                this.adminusers.unshift(res.data)
                $('#addNewModal').modal('hide')
                this.success('Product Added Successfully');
                
                this.data.fullName='',
                this.data.email='',
                this.data.password='',
                this.data.userType='',
                this.data.status=''

            }else if(res.status == 422){
                if(res.data.errors.fullName){
                    this.error(res.data.errors.fullName[0])
                }else if(res.data.errors.email){
                    this.error(res.data.errors.email[0])
                }else if(res.data.errors.password){
                    this.error(res.data.errors.password[0])
                }
            }else{
                this.swr()
            }

        },

        showEditModal(user,index){
            let obj = {
                id : user.id,
                fullName: user.fullName,
                email : user.email,
                userType: user.userType,
                status: user.status,
            }
            this.editData = obj
            this.index = index
            $('#editModal').modal('show')
        },
        async editAdminUser(){
            if(this.editData.fullName.trim()=='') return this.error('EullName is Required')
            if(this.editData.email.trim()=='') return this.error('Email is Required')
            if(this.editData.userType=='') return this.error('Admin Type is Required')
            if(this.editData.status=='') return this.error('Status is Required')

            const res = await this.callApi('post','/app/edit_adminuser', this.editData)
            if(res.status == 200){

                this.adminusers[this.index].fullName = this.editData.fullName
                this.adminusers[this.index].email = this.editData.email
                this.adminusers[this.index].userType = this.editData.userType
                this.adminusers[this.index].status = this.editData.status

                this.success('Admin Information Updated Successfully')

                //close modal
                $('#editModal').modal('hide')
            }else{
                this.error('Admin Can not be updated')
            }
        },

        async deleteAdminUser(user, index){
            if(!confirm('Are You Sure')) return
    
            const res = await this.callApi('post','/app/delete_adminuser', user)
            if(res.status == 200){
                this.adminusers.splice(index,1)
                this.success('Admin Deleted Successfully')
            }else{
                this.swr()
            }
        }
    },

    async created(){
        await this.loadAdminUsers()
    }


}
</script>