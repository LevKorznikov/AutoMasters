async function myFunction(){
    let user = {
        username: document.getElementById('name').value,
        password: document.getElementById('pass').value
      };
    
    let response = await fetch('http://localhost/auto_dungeon_masters/api/register.php', {
        
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(user)
      });
      
      let result = await response.json();
      
}
