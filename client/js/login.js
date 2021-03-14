const App = {
    data() {
        return{
            login: '',
            password: '',
            error: ''
        }
    },
    methods: {
        async tryToLogin(){
            const user = {
                login: this.login,
                password: this.password
            }
            let result = await request('/plants-store/server/login.php', 'POST', user)
            console.log(result)
            if(!result.error){
                if(result.Id === 0){
                    document.location.href = '/plants-store/client/view/admin/admin-page.html'
                }else{
                    document.location.href = '/plants-store/client/view/home-page.html'
                }
            }else{
                this.error = 'User with this login or password does not exist'
            }
        },
    }
}

Vue.createApp(App).mount('.container')