<template>
    <div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    Category List
                </h2>

                <div class="card-tools">
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#staticBackdrop">
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
                        <tr>
                            <td>183</td>
                            <td>Television</td>
                            <td>Published</td>
                            <td>27 Jan 2020</td>
                            <td>
                                    <button type="button" class="btn btn-primary btn-sm">
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

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                <label for="categoryName">Category Name</label>
                                <input type="text" class="form-control" id="categoryName">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Create Now</button>
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
            },
        }
    },


    async created(){
        const res = await this.callApi('post','/app/add_category', {categoryName: 'Akram'});
        console.log(res)
    }
}
</script>