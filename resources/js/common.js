export default {
    data(){
        return {

        }
    },
    methods: {
        async callApi(method, url, dataObj){
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });
            } catch (e) {
                return e.response 
            }
        },

        success(text){
            this.$swal({
                toast: true,
                showConfirmButton: false,
                icon: 'success',
                text: text,
                position: 'top-end',
                timer: 3000
            })
        },
        error(text){
            this.$swal({
                toast: true,
                showConfirmButton: false,
                icon: 'error',
                text: text,
                position: 'top-end',
                timer: 3000
            })
        },
        info(text){
            this.$swal({
                toast: true,
                showConfirmButton: false,
                icon: 'info',
                text: text,
                position: 'top-end',
                timer: 3000
            })
        },
        warning(text){
            this.$swal({
                toast: true,
                showConfirmButton: false,
                icon: 'warning',
                text: text,
                position: 'top-end',
                timer: 3000
            })
        },
        swr(text="Someting Went Wrong"){
            this.$swal({
                toast: true,
                showConfirmButton: false,
                icon: 'question',
                text: text,
                position: 'top-end',
                timer: 3000
            })
        },
    }
}