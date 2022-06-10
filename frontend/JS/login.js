async function myFunction2(){
  let user = {
      username: document.getElementById('name').value,
      password: document.getElementById('pass').value
    };
  let response = await fetch('http://localhost/auto_dungeon_masters/api/login.php', {
      
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Access-Control-Allow-Credentials': 'true',
        'Access-Control-Allow-Headers': 'Origin, Content-Type, Accept, Authorization, X-Request-With, Set-Cookie, Cookie, Bearer',
        'Content-Type': 'application/json;charset=utf-8',
        
      },
      body: JSON.stringify(user)
    });
    
    document.cookie = `user=${user.username}`;
    let cook = document.cookie;
    let result = await response.json();
    let token = result.token;
    localStorage.setItem('token', token);
    let token1 = localStorage.getItem('token');
    alert('Добро пожаловать ' + cook.slice(5));
}
