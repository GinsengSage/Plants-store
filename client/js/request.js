async function request(url, method = 'GET', data = null){
    try{
        const headers = {}
        let body
        if(data){
            headers['Content-Type'] = 'application/json'
            body = JSON.stringify(data)
        }
        const response = await fetch(url, {
            method,
            mode: "same-origin",
            credentials: "same-origin",
            headers,
            body
        })
        return response.json()
    }catch (e){
        console.warn('Error ' + e.message)
    }
}