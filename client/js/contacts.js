const App = {
    data(){
        return{
            name:'',
            email:'',
            phone:'',
            subject:'',
            message:''
        }
    },
    methods:{
        async sendMessage(){
            let data = {
                name:this.name,
                email:this.email,
                phone:this.phone,
                subject:this.subject,
                message:this.message
            }

            let result = await request('/plants-store/server/contacts.php', 'POST', data)
            if(result.ok){
                alert('Message was sended')
            }else{
                alert('Error')
            }

        }
    }
}

Vue.createApp(App).mount('body')