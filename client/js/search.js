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
        },
        async addToCart(plantId){
            let data = {
                plantId
            }
            let result = await request('/plants-store/server/home.php?action=addToCart', 'POST', data)
            if(!result.error){
                this.plants.forEach(p => {
                    if(p.id === plantId)
                        p.inCart = true
                })
            }
            else{
                alert('System error')
            }
        },
        async addToLiked(plantId){
            let data = {
                plantId
            }
            let result = await request('/plants-store/server/home.php?action=addToLiked', 'POST', data)
            if(!result.error){
                this.plants.forEach(p => {
                    if(p.id === plantId)
                        p.liked = true
                })
            }
            else{
                alert('System error')
            }
        },
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