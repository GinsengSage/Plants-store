const App = {
    data() {
        return {
            plant: {},
            stars: [],
        }
    },
    methods: {
        async addToLiked(plantId, liked) {

            if(!liked){
                let data = {
                    plantId
                }
                let result = await request('/plants-store/server/one-plant.php?action=addToLiked', 'POST', data)
                if (!result.error) {
                    this.plant.liked = true
                    alert('Plant was added into a liked')
                }else{
                    alert('System error')
                }
            }else{
                alert('Plant already in liked')
            }
        },
        async addToCart(plantId, inCart){
            if(!inCart){
                let data = {
                    plantId
                }
                let result = await request('/plants-store/server/one-plant.php?action=addToCart', 'POST', data)
                if (!result.error) {
                    this.plant.inCart = true
                    alert('Plant was added into a cart')
                }else{
                    alert('System error')
                }
            }else {
                alert('Plant already in cart')
            }
        }
    },
    async mounted() {
        let result = await request('/plants-store/server/one-plant.php', 'GET');
        this.plant = result.plant
        let i = this.plant.rating
        while (i > 0) {
            this.stars.push({})
            i--;
        }
        console.log(this.plant)
    }
}

Vue.createApp(App).mount('.container')