const App = {
    data(){
        return{
            plant:{
                name:'',
                type:'',
                color:'',
                price:'',
                height:'',
                rating:'',
                desc:'',
                url:'',
            },
            blog:{
                title:'',
                previw:'',
                text:'',
                url:'',
            },
            plants:[],
            blogs:[],
            types: [
                'house plants',
                'exclusive plants',
                'garden plants',
                'office plants',
            ],
            contentCode:'AP'
        }
    },
    methods:{
        plantValidator(){

        },
        blogValidator(){

        },
        async addNewPlant(){

        },
        async addNewBlog(){

        },
        async removePlant(plantId){

        },
        async removeBlog(blogId){

        },
        changeContent(code){
            this.contentCode = code
        }
    },
    computed:{

    },
    async mounted(){
        this.plants = await request('/plants-store/server/plants.php')
        this.blogs = await request('/plants-store/server/blog.php')
    }
}
Vue.createApp(App).mount('.container')