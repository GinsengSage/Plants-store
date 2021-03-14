const App = {
    data(){
        return{
            blog: {},
            comments: [],
            commentsCount: 0,
            inputText: ''
        }
    },
    methods:{
        async addComment(){
            if(this.inputText){
                let date = moment().format('D MMM, YYYY, HH:MM A');
                let data = {
                    text: this.inputText,
                    date
                }
                let result = await request('/plants-store/server/one-blog.php', 'POST', data)
                if(result.ok){
                    this.comments = await request('/plants-store/server/one-blog.php?action=GetComments')
                    this.commentsCount++
                    this.inputText = ''
                }else{
                    alert('Error')
                }
            }
        }
    },
    async mounted(){
        this.blog = await request('/plants-store/server/one-blog.php?action=getBlog')
        this.comments = await request('/plants-store/server/one-blog.php?action=GetComments')
        this.commentsCount = this.comments.length
    }
}

Vue.createApp(App).mount('body')