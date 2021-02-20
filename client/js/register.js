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
            if(this.password !== this.repeatPassword){
                this.error = 'Your passwords do not match'
                return
            }else {
                this.tryToInsertUser().then()
            }
        },
        async tryToInsertUser(){
            let user = {
                name: this.name,
                login: this.login,
                email: this.email,
                address: this.address,
                password: this.password,
            }
            let result = await request('/plants-store/server/register.php', 'POST', user)
            if(result.error){
                this.error = result.message;
            }else{
                document.location.href = '/plants-store/client/view/home-page.html'
            }
        }
    }
}
Vue.createApp(App).mount('.container')