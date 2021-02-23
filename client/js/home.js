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
        async addToCart(plantId, inCart){
            if(inCart){
                alert('The plant is already in the cart')
            }else{
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
            }
        },
        async addToLiked(plantId, liked){
            if(liked){
                alert('The plant is already in the favorites')
            }else{
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
            }
        }
    },
    mounted(){
        this.getPlants().then(()=>$('.slider').slick())
    }

}

Vue.createApp(App).mount('body')