const tableBody = document.querySelector('#table-container');



function viewAllFillingStations(){
  fetch('http://localhost/oluaka/new-fuelalert/api/fuel_price_apis/get_fuel_prices.php')
  .then(res => res.json())
  .then(data => {
    // console.log(data)
    data.records.map((stations)=>{
      if(stations.price != null){

      tableBody.innerHTML += `      <tr>
      <td>${stations.name}</td>
      <td>${stations.address}</td>
      <td>${stations.area}</td>
      <td>${stations.state}</td>
      <td>${stations.fuel_price}</td>

    </tr>
`
      }
    })
  })
  .catch(err => console.log(err))
}
viewAllFillingStations()
