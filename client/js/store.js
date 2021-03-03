const App = {
    data(){
        return{
            currentPlants: [],
            plants: [],
            count: 0,
            userId: 0,
            sliderValue: 300,
            selected: 'name'
        }
    },
    methods:{
        async addToCart(plantId){
            let data = {
                plantId
            }
            let result = await request('/plants-store/server/home.php?action=addToCart', 'POST', data)
            if(!result.error){
                this.currentPlants.forEach(p => {
                    if(p.id === plantId)
                        p.inCart = true
                })
                this.plants = [...this.currentPlants]
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
                this.currentPlants.forEach(p => {
                    if(p.id === plantId)
                        p.liked = true
                })
                this.plants = [...this.currentPlants]
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
        },
        typeFilter(type){
            if(type !== 'All')
                this.currentPlants = this.plants.filter(p => p.type === type )
            else
                this.currentPlants = this.plants
            this.count = this.currentPlants.length
        },
        colorFilter(color){
            if(color !== 'All')
                this.currentPlants = this.plants.filter(p => p.color === color )
            else
                this.currentPlants = this.plants
            this.count = this.currentPlants.length
        },
        sortByName(){
            this.currentPlants.sort(function (a, b) {
                if (a.name > b.name) {
                    return 1;
                }
                if (a.name < b.name) {
                    return -1;
                }
                return 0;
            })
        },
        sortByPrice(){
            this.currentPlants.sort(function (a, b) {
                return a.price - b.price
            })
        },
        sortByColor(){
            this.currentPlants.sort(function (a, b) {
                if (a.color > b.color) {
                    return 1;
                }
                if (a.color < b.color) {
                    return -1;
                }
                return 0;
            })
        },
        sortRouter(){
            switch (this.selected){
                case 'name':
                    this.sortByName()
                    break
                case 'price':
                    this.sortByPrice()
                    break
                case 'color':
                    this.sortByColor()
                    break
            }
        },
        priceController(){
            console.log(this.plants)
            this.currentPlants = this.plants.filter(p => parseInt(p.price) < this.sliderValue )
            console.log(this.currentPlants)
        }
    },
    async mounted(){
        let result = await request('/plants-store/server/plants.php')
        this.plants = result.plants
        this.currentPlants = [...this.plants]
        this.count = this.currentPlants.length
        this.userId = result.userId
        this.sortByName()
    }
}
Vue.createApp(App).mount('body')