const App = {
    data(){
        return{
            userId: 0,
            plants: [],
            sliderPlants: [],
        }
    },
    methods: {
        async getPlants(){
            let result = await request('/plants-store/server/plants.php')
            this.plants = result.plants.slice(0,5)
            this.sliderPlants = result.plants.slice(0,4)
            this.userId = result.userId
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
    mounted(){
        this.getPlants().then(()=>$('.slider').slick())
    }

}

Vue.createApp(App).mount('body')