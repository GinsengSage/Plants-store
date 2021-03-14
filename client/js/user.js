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
            let result = await request('/plants-store/server/liked.php?action=removeFromLiked', 'POST', data)
            if(result.ok){
                this.likedPlants = await request('/plants-store/server/liked.php?action=getLikedPlants')
            }else{
                alert('Error')
            }
        },
        async closeSession(){
            let result = await request('/plants-store/server/liked.php?action=closeSession', 'POST', {})
            if(result.ok){
                document.location.href = '/plants-store/client/view/index.html'
            }
        }
    },
    async mounted(){
        this.likedPlants = await request('/plants-store/server/liked.php?action=getLikedPlants')
        this.user = await request('/plants-store/server/liked.php?action=getPersonalInfo')
    }
}

Vue.createApp(App).mount('body')