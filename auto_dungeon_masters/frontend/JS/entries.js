async function myFunction3(){
  
    let token = localStorage.getItem('token');
    let t1 =parseJwt (token);
    let response = await fetch('http://localhost/auto_dungeon_masters/api/entries.php', {
        
        method: 'GET',
        headers: {
          'Authorization': 'Bearer ' + token,
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify()
        
      }).then(response => response.json())
      .then(data => {
        
          data.forEach(element => { 
          $('#table').append('<tr><td>' + element.user_id + 
          '</td><td>' + element.full_name + '</td><td>' + element.phone_number + 
          '</td><td>' + element.car_number + '</td><td>' + element.car_brand + 
          '</td><td>' + element.service_type + '</td><td>' + element.status + '</td></tr>');
        });
        
      }); 
           
}

function parseJwt (token) {
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
  var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
      return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
  }).join(''));

  return JSON.parse(jsonPayload);
}