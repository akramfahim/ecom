<template>
    <div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    Product List
                </h2>

                <div class="card-tools">
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addNewModal">
                        <i class="fas fa-plus"></i> 
                        Create Product
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Product Description</th>
                            <th>Product Image</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product,index) in products" :key="index" v-if="products.length">
                            <td>{{index+1}}</td>
                            <td>{{ product.productName}}</td>
                            <td>{{ product.productDescription}}</td>
                            <td>
                                <img :src="`/uploads/${product.productImage}`" alt="Product Image" width="50" height="40">
                            </td>
                            <td>{{product.productPrice}}</td>
                            <td>{{ product.category_id }}</td>
                            <td>{{ product.productStatus}}</td>
                            <td>
                                <button type="button" @click="showEditModal(product,index)" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </button>
                                <button type="button" @click="deleteProduct(product,index)" class="btn btn-danger btn-sm">
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

        <!-- Add New Product Modal -->
        <div class="modal fade" id="addNewModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" v-model="data.productName" class="form-control" placeholder="Product Name">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" v-model="data.productDescription" id="description" rows="5" placeholder="Product Description"></textarea>
                                    </div>
                                    
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <select v-model="data.category_id" class="form-control" id="status">
                                            <option value="">Select Category</option>
                                            <option :value="category.id" v-for="(category,i) in categories" :key="i">{{ category.categoryName}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" v-model="data.productPrice" class="form-control" id="categoryName" placeholder="Product Price">
                                    </div>
                                    <div class="form-group">
                                        <input type="file" @change="uploadPhoto" class="form-control-file" id="file1">
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" id="status" v-model="data.productStatus">
                                            <option value="">Select Publication Status</option>
                                            <option value="publish">Publish</option>
                                            <option value="unpublish">Unpublish</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" @click="createProduct" class="btn btn-primary">
                            Create Now
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Product Modal -->
        <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-7">
                                    <div class="form-group">
                                        <input type="text" v-model="editData.productName" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" v-model="editData.productDescription" id="description" rows="5"></textarea>
                                    </div>
                                    
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <select v-model="editData.category_id" class="form-control" id="status">
                                            <option v-for="(category,i) in categories" :key="i" :value="category.id">{{ category.categoryName}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" v-model="editData.productPrice" class="form-control">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <img :src="getProductImage()" alt="Product Image" width="100" height="60">
                                        </div>
                                        <div class="col-8">
                                            <input type="file" @change="updatePhoto" class="form-control-file" id="file1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" id="status" v-model="editData.productStatus">
                                            <option value="publish">Publish</option>
                                            <option value="unpublish">Unpublish</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="submitEditProductForm" :disabled="isUpdating" :loading="isUpdating">
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
                productName: '',
                productDescription: '',
                category_id : '',
                productPrice : '',
                productImage : '',
                productStatus: ''
            },
            products: [],
            categories: [],

            editData:{
                productName: '',
                productDescription: '',
                category_id : '',
                productPrice : '',
                productImage : '',
                productStatus: ''
            },
            index : -1,
            isUpdating : false

        }
    },
    methods:{
        async loadCategory(){
            const categories = await this.callApi('get','/app/all_categories')
            this.categories = categories.data
        },
        async loadProducts(){
            const res = await this.callApi('get','/app/all_products')
            this.products = res.data
        },

        uploadPhoto(element){
            var file = element.target.files[0];
            //console.log(file)
            var reader = new FileReader();
            reader.onloadend = (file) => {
                //console.log('RESULT', reader.result)
                this.data.productImage = reader.result
            }
            reader.readAsDataURL(file);
        },
        updatePhoto(element){
            var file = element.target.files[0];
            //console.log(file)
            var reader = new FileReader();
            reader.onloadend = async (file) => {
                //console.log('RESULT', reader.result)
                const res =  await this.callApi('post','/app/upload_image', reader.result)
                //console.log(res.data)
                if(res.status==200){
                    console.log(res.data)
                    this.editData.productImage = res.data
                }
            }
            reader.readAsDataURL(file);
        },
        getProductImage(){
            let photo =  (this.editData.productImage != '') ? `/uploads/${this.editData.productImage}` : `/uploads/defaultProduct.png`

             return photo
        },

        async createProduct(){

            if(this.data.productName.trim()=='') return this.error('Product Name is required')
            if(this.data.productDescription.trim()=='') return this.error('Description is required')
            if(this.data.category_id=='') return this.error('Category is required')
            if(this.data.productPrice.trim()=='') return this.error('Price is required')

            const res = await this.callApi('post','/app/add_product',this.data)
            if(res.status == 201){
                this.products.unshift(res.data.product)
                $('#addNewModal').modal('hide')
                this.success('Product Added Successfully');
                
                this.data.productName='',
                this.data.productDescription='',
                this.data.category_id='',
                this.data.productImage='',
                this.data.productPrice='',
                this.data.productStatus=''

            }else if(res.status == 422){
                if(res.data.errors.productName){
                    this.error(res.data.errors.productName[0])
                }else if(res.data.errors.productDescription){
                    this.error(res.data.errors.productDescription[0])
                }else if(res.data.errors.productPrice){
                    this.error(res.data.errors.productPrice[0])
                }else if(res.data.errors.productImage){
                    this.error(res.data.errors.productImage[0])
                }
            }else{
                this.swr()
            }
        },

        //show edit modal
        showEditModal(product,index){
            let obj = {
                id : product.id,
                productName: product.productName,
                productDescription : product.productDescription,
                productPrice: product.productPrice,
                productImage: product.productImage,
                category_id: product.category_id,
                category: product.category.categoryName,
                productStatus : product.productStatus
            }
            this.editData = obj
            this.index = index
            $('#editModal').modal('show')
        },
        async submitEditProductForm(){
            if(this.editData.productName.trim()=='') return this.error('Product Name is Required')
            if(this.editData.productDescription.trim()=='') return this.error('Product Description is Required')
            if(this.editData.productPrice=='') return this.error('Product Price is Required')
            if(this.editData.category_id=='') return this.error('Product Category is Required')
            if(this.editData.productStatus.trim()=='') return this.error('Product Status is Required')

            const res = await this.callApi('post','/app/edit_product', this.editData)
            if(res.status == 200){

                this.products[this.index].productName = this.editData.productName
                this.products[this.index].productDescription = this.editData.productDescription
                this.products[this.index].productPrice = this.editData.productPrice
                this.products[this.index].category_id = this.editData.category_id
                this.products[this.index].productImage = this.editData.productImage
                this.products[this.index].productStatus = this.editData.productStatus

                this.success('Product Update Successfully')

                //close modal
                $('#editModal').modal('hide')
            }else{
                this.error('Product Can not be updated')
            }

            //console.log(this.editData)
        },
        async deleteProduct(product, index){
            if(!confirm('Are You Sure')) return
    
            const res = await this.callApi('post','/app/delete_product', product)
            if(res.status == 200){
                this.products.splice(index,1)
                this.success('Product Deleted Successfully')
            }else{
                this.swr()
            }
        }
    },
    async created(){
        await Promise.all([
            this.loadCategory(), 
            this.loadProducts()
        ])

    }

}
</script>