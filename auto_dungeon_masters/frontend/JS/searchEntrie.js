async function myFunction6(){
  
  let token = localStorage.getItem('token');
  let t1 =parseJwt (token);
  let response = await fetch('http://localhost/auto_dungeon_masters/api/searchEntrie.php?full_name=' + document.getElementById('search').value, {
      
      method: 'GET',
      headers: {
        'Authorization': 'Bearer ' + token,
        'Content-Type': 'application/json;charset=utf-8'
      },
      body: JSON.stringify()
      
    }).then(response => response.json())
    .then(deleteRow('table'))
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

function deleteRow(tableID) {
  var tableHeaderRowCount = 1;
  var table = document.getElementById(tableID);
  var rowCount = table.rows.length;
  for (var i = tableHeaderRowCount; i < rowCount; i++) {
      table.deleteRow(tableHeaderRowCount);
  }
}