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
                            <td>{{ product.category_id}}</td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
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
            categories: []

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
        }
    },
    async created(){
        await this.loadCategory()
        await this.loadProducts()
    }

}
</script>