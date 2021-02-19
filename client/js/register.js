const App = {
    data(){
        return {
            name: '',
            login: '',
            email: '',
            address: '',
            password: '',
            repeatPassword: '',
            error: ''
        }
    },
    methods:{
        validator(){

        },
        async tryToInsertUser(){
            if(this.password !== this.repeatPassword){
                this.error = 'Your passwords do not match'
                return
            }else{
                let user = {
                    name: this.name,
                    login: this.login,
                    email: this.email,
                    address: this.address,
                    password: this.password,
                }

                let result = await request('/plants-store/server/register.php', 'POST', user)

            }

        }
    }
}

Vue.createApp(App).mount('.container')