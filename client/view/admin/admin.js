const App = {
    data(){
        return{
            plant:{
                name:'',
                type:'House plants',
                color:'Green',
                price:'',
                height:'',
                rating: 1,
                desc:'',
                url:'',
            },
            blog:{
                title:'',
                preview:'',
                text:'',
                url:'',
            },
            plants:[],
            blogs:[],
            contentCode:'AP',
            activeNavItem: 1
        }
    },
    methods:{
        upperCaseConverter(str){
            return str.charAt(0).toUpperCase() + str.slice(1)
        },
        plantValidator(){
            if(isNaN(+this.plant.price) || isNaN(+this.plant.height)){
                if(+this.plant.price > 200 || +this.plant.price < 0 || +this.plant.height > 200 || +this.plant.height < 0){
                    alert('Your enter incorrect number value')
                    return
                }
                alert('Your price or height or rating is not a number')
                return
            }

            if(this.plant.url.includes('.png') || this.plant.url.includes('.jpg')){
                this.plant.url = this.plant.url.slice(0, this.plant.url.length - 5)
                this.plant.url = this.plant.url.toLowerCase()
            }

            this.plant.name = this.upperCaseConverter(this.plant.name)
            this.plant.desc = this.upperCaseConverter(this.plant.desc)

            this.plant.price = +this.plant.price
            this.plant.height = +this.plant.height

            this.addNewPlant(this.plant)
        },
        blogValidator(){
            if(this.blog.url.includes('.png') || this.blog.url.includes('.jpg')){
                this.blog.url = this.blog.url.slice(0, this.blog.url.length - 5)
                this.blog.url = this.blog.url.toLowerCase()
            }

            this.blog.title = this.upperCaseConverter(this.blog.title)
            this.blog.preview = this.upperCaseConverter(this.blog.preview)
            this.blog.text = this.upperCaseConverter(this.blog.text)

            this.addNewBlog(this.blog)
        },
        async addNewPlant(data){
            let result = await request('/plants-store/server/admin.php?action=addNewPlant', 'POST', data)
            if(result.ok){
                alert('Plant was added!')
                this.plant.name = ''
                this.plant.price = ''
                this.plant.height = ''
                this.plant.desc = ''
                this.plant.url = ''
                let result = await request('/plants-store/server/plants.php')
                this.plants = result.plants
            }else{
                alert('Error!')
            }
        },
        async addNewBlog(data){
            let result = await request('/plants-store/server/admin.php?action=addNewBlog', 'POST', data)
            if(result.ok){
                this.blog.title = ''
                this.blog.preview = ''
                this.blog.text = ''
                this.blog.url = ''
                this.blogs = await request('/plants-store/server/blog.php')
                alert('Blog was added!')
            }else{
                alert('Error!')
            }
        },
        async removePlant(plantId){
            let data = {
                plantId,
            }
            let result = await request('/plants-store/server/admin.php?action=removePlant', 'POST', data)
            if(result.ok){
                alert('Plant was deleted!')
                let result = await request('/plants-store/server/plants.php')
                this.plants = result.plants
            }else{
                alert('Error!')
            }
        },
        async removeBlog(blogId){
            let data = {
                blogId,
            }
            let result = await request('/plants-store/server/admin.php?action=removeBlog', 'POST', data)
            if(result.ok){
                alert('Blog was deleted!')
                this.blogs = await request('/plants-store/server/blog.php')
            }else{
                alert('Error!')
            }
        },
        changeContent(code, index){
            this.contentCode = code
            this.activeNavItem = index
        },
        exit(){
            let result = confirm('Are you sure?')
            if(result){
                document.location.href = '/plants-store/client/view/index.html'
            }else{
                return
            }
        }
    },
    async mounted(){
        let result = await request('/plants-store/server/plants.php')
        this.plants = result.plants
        this.blogs = await request('/plants-store/server/blog.php')
    }
}
Vue.createApp(App).mount('.container')