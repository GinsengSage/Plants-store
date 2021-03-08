const App = {
    data(){
        return{
            user: {},
            likedPlants: []
        }
    },
    methods:{
        async removeFromLiked(plantId){
            let data = {
                plantId
            }
            let result = await request('/plants-store/server/liked.php', 'POST', data)
            if(result.ok){
                this.likedPlants = await request('/plants-store/server/liked.php?action=getLikedPlants')
            }else{
                alert('Error')
            }
        }
    },
    async mounted(){
        this.likedPlants = await request('/plants-store/server/liked.php?action=getLikedPlants')
        this.user = await request('/plants-store/server/liked.php?action=getPersonalInfo')
        console.log(this.likedPlants)
    }
}

Vue.createApp(App).mount('body')