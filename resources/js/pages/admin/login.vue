<template>
    <div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-8 offset-lg-3 offset-md-3 offset-sm-2">
                <div>
                    <h2 class="text-center"><b>Ecom Admin Area</b></h2>
                    <hr/>
                </div>
                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" v-model="data.email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password: </label>
                        <input type="password" class="form-control" v-model="data.password" id="password">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block" @click="login()" :disabled="isLogging" :loading="isLogging">
                            {{ isLogging ? 'Logging...' : 'Login Now'}}
                        </button>
                    </div>

            </div>
        </div>
       
    </div>
</template>
<script>
export default {
    data(){
        return {
            data: {
                email: '',
                password: ''
            },
            isLogging: false
        }
    },
    methods:{
        async login(){
            if(this.data.email.trim() == '' ) return this.error('Email Is Required')
            if(this.data.password.trim() == '' ) return this.error('Password Is Required')
            if(this.data.password.length < 6 ) return this.error('Incorrect Login Details')

            this.isLogging=true
            const res = await this.callApi('post','app/login_admin',this.data)
            if(res.status === 200){
                this.success('You Are Login Now')
                window.location = '/'
            }else if(res.status === 401){
                this.error(res.data.msg)
            }else{
                this.swr()
            }
            this.isLogging=false
        }
    }
}
</script>

<style scoped>
.row{
    background-color:#f8fafc !important;
    margin-top: 15%;
}
</style> 
