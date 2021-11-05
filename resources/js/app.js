require('./bootstrap');

axios.get('sanctum/csrf-cookie').then(response => {
    //console.log(response)
    axios.post('api/login',{
        email:'higao@email.com',
        password:'root123'
    }).then((response)=>{
        axios.get('api/me').then(response2 => {
            console.log(response2)
        });
    }).catch((error)=>{
        console.log(error)
    });
});


