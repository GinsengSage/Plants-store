const App = {
    data(){
        return{
            blogs: [],
        }
    },
    methods:{
        async openSession(blogId){
            let data = {
                blogId,
            }
            let result = await request('/plants-store/server/blog.php', 'POST', data)
            if(result.ok){
                document.location.href = '/plants-store/client/view/one-blog-page.html'
            }
        }
    },
    async mounted(){
        this.blogs = await request('/plants-store/server/blog.php')
    }
}
Vue.createApp(App).mount('body')