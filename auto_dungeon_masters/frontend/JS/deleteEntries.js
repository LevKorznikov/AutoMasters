async function myFunction7(){
  let u_id = document.getElementById('search').value;
  let token = localStorage.getItem('token');
  let user = {
    user_id: u_id
  };
  var Table = document.getElementById("table");
  let response = await fetch('http://localhost/auto_dungeon_masters/api/deleteEntries.php', {
      
      method: 'POST',
      headers: {
        'Authorization': 'Bearer ' + token,
        'Content-Type': 'application/json;charset=utf-8'
      },
      body: JSON.stringify(user)
      
    }).then(response => response.json())
    .then(deleteRow('table'))
    .then(myFunction3());      
}

function deleteRow(tableID) {
  var tableHeaderRowCount = 1;
  var table = document.getElementById(tableID);
  var rowCount = table.rows.length;
  for (var i = tableHeaderRowCount; i < rowCount; i++) {
      table.deleteRow(tableHeaderRowCount);
  }
}
