async function myFunction5(){
  let token = localStorage.getItem('token');
  let t1 =parseJwt (token);
  let entrie = {
      user_id: t1.id,
      full_name: document.getElementById('FIO').value,
      phone_number: document.getElementById('phone').value,
      car_number: document.getElementById('number').value,
      car_brand: document.getElementById('mark').value,
      service_type: document.getElementById('app').value
    };
    console.log(JSON.stringify(entrie));

  let response = await fetch('http://localhost/auto_dungeon_masters/api/updateEntries.php', {
      method: 'POST',
      headers: {  
          'Authorization': 'Bearer ' + token
      },
      body: JSON.stringify(entrie)
  });

  let result = await response.json();
}

function parseJwt (token) {
var base64Url = token.split('.')[1];
var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
}).join(''));

return JSON.parse(jsonPayload);
}
