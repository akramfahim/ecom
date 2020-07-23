<template>
    <div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    Category List
                </h2>

                <div class="card-tools">
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addNewModal">
                        <i class="fas fa-plus"></i> 
                        Create Category
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(category,index) in categories" :key="index" v-if="categories.length">
                            <td>{{index+1}}</td>
                            <td>{{ category.categoryName}}</td>
                            <td>{{category.status}}</td>
                            <td>{{category.created_at}}</td>
                            <td>
                                    <a href="#" @click="showEditModal(category,index)" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" @click="deleteCategory(category,index)" :laoding="category.isDeleting">
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
                        <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <input type="text" v-model="data.categoryName" class="form-control" id="categoryName" placeholder="Category Name">
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="status" v-model="data.status">
                                    <option value="">Select Publication Status</option>
                                    <option value="publish">Publish</option>
                                    <option value="unpublish">Unpublish</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="submitCategroyForm" :disabled="isAdding" :loading="isAdding">
                            {{ isAdding ? 'Creating...' : 'Create Now'}}
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <input type="text" v-model="editData.categoryName" class="form-control" id="categoryName" placeholder="Category Name">
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="status" v-model="editData.status">
                                    <option value="publish">Publish</option>
                                    <option value="unpublish">Unpublish</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="submitEditCategoryForm" :disabled="isUpdating" :loading="isUpdating">
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
                categoryName: '',
                status: '' 
            },
            addCategoryModal: false,
            isAdding: false,
            categories: [],

            editData:{
                categoryName: '',
                status: ''
            },
            isUpdating: false,
            index: -1
        }
    },
    methods: {
        async submitCategroyForm(){
            if(this.data.categoryName.trim()=='') return this.error('Category Name is Required')

            const res = await this.callApi('post','/app/add_category', this.data)
            if(res.status==201){
                this.categories.unshift(res.data)
                this.success('Category Created Successfully')

                //close modal
                $('#addNewModal').modal('hide')

                this.data.categoryName = '',
                this.data.status = ''
            }else if(res.status == 422){
                if(res.data.errors.categoryName){
                    this.error(res.data.errors.categoryName[0])
                }
            }else{
                this.swr()
            }
        },

        showEditModal(category,index){
            let obj = {
                id : category.id,
                categoryName: category.categoryName,
                status : category.status
            }
            this.editData = obj
            this.index = index
            $('#editModal').modal('show')
        },
        async submitEditCategoryForm(){
            if(this.editData.categoryName.trim()=='') return this.error('Category Name is Required')

            const res = await this.callApi('post','/app/edit_category', this.editData)
            if(res.status==200){
                this.categories[this.index].categoryName = this.editData.categoryName
                this.categories[this.index].status = this.editData.status

                this.success('Category Updated Successfully')
                //close modal
                $('#editModal').modal('hide')
            }else if(res.status == 422){
                if(res.data.errors.categoryName){
                    this.error(res.data.errors.categoryName[0])
                }
            }else{
                this.swr()
            }
        },

        async deleteCategory(category, index){
            if(!confirm('Are You Sure')) return
    
            const res = await this.callApi('post','/app/delete_category', category)
            if(res.status == 200){
                this.categories.splice(index,1)
                this.success('Category Deleted Successfully')
            }else{
                this.swr()
            }

        }

        
    },


    async created(){
        const res = await this.callApi('get','/app/all_categories')
        if(res.status == 200){
            this.categories = res.data
        }else{
            this.swr()
        }
    }
}
</script>