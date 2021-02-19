const App = {
    data(){
        return{
            plants: [],
            sliderPlants: []
        }
    },
    methods: {

    },
    async mounted(){
        this.plants = plants
        this.sliderPlants = this.plants.slice(0,4)
        // this.plants = await request('/plants-store/server/home.php', 'GET')
    }
}

const plants = [
    {
        id: 1,
        name: 'House shape close',
        price: '$350.00',
        height: '155 mm',
        type: 'House plant, office plant'
    },
    {
        id: 2,
        name: 'House shape close 2',
        price: '$370.00',
        height: '165 mm',
        type: 'House plant, office plant'
    },
    {
        id: 3,
        name: 'House shape close 3',
        price: '$370.00',
        height: '165 mm',
        type: 'House plant, office plant'
    },
    {
        id: 4,
        name: 'House shape close 4',
        price: '$370.00',
        height: '165 mm',
        type: 'House plant, office plant'
    },
    {
        id: 5,
        name: 'House shape close 5',
        price: '$370.00',
        height: '165 mm',
        type: 'House plant, office plant'
    }
]

Vue.createApp(App).mount('body')