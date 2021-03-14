const App = {
    data(){
        return{
            cartPlants: [],
            subTotalSum: 0,
            postValue: 0,
            totalSum: 0
        }
    },
    methods:{
        async removeFromCart(plantId){
            let data = {
                plantId
            }
            let result = await request('/plants-store/server/cart.php?action=removePlant', 'POST', data)
            if(result.ok){
                this.cartPlants = await request('/plants-store/server/cart.php')
                this.cartPlants.forEach(p => {
                    p = Object.assign(p, {count: 1})
                })
                console.log(this.cartPlants)
                this.summarize()
            }else{
                alert('Error')
            }
        },
        summarize(){
            this.subTotalSum = this.cartPlants.reduce((total, p) =>  {
                return total + +p.price*p.count
            }, 0)
            this.totalSum = +this.subTotalSum +  +this.postValue
        },
        async sendOrder(){

            let user = await request('/plants-store/server/liked.php?action=getPersonalInfo.php')

            let plantsList = []

            this.cartPlants.forEach(p => {
                let plantItem = {
                    name: p.name,
                    count: p.count
                }
                plantsList.push(plantItem)
            })

            let data = {
                name: user.name, 
                email: user.email,
                address: user.address,
                plantsList,
                sum: totalSum,
            }

            let result = await request('/plants-store/server/cart.php?action=sendOrder', 'POST', data)
            if(result.ok){
                alert("Your order is sended")
                subResult = await request('/plants-store/server/cart.php?action=cleanCart', 'POST', {data})
            }else{
                alert("Error")
            }
        }
    },
    watch:{
        postValue(value){
            this.summarize()
        }
    },
    async mounted(){
        this.cartPlants = await request('/plants-store/server/cart.php')
        this.cartPlants.forEach(p => {
            p = Object.assign(p, {count: 1})
        })
        this.summarize()
    }
}

Vue.createApp(App).mount('.container')