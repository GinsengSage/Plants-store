const App = {
    data(){
        return{
            inputValue: '',
            plants: []
        }
    },
    methods:{
        async openSession(plantId){
            let data = {
                plantId
            }
            let result = await request('/plants-store/server/home.php?action=openSession', 'POST', data)
            if(!result.error){
                document.location.href = '/plants-store/client/view/one-plant-page.html'
            }
        }
    },
    watch:{
        async inputValue(value){
            if(value)
                this.plants = await request(`/plants-store/server/search.php?name=${value}`)
            else
                this.plants = []
        }
    }
}
Vue.createApp(App).mount('.container')