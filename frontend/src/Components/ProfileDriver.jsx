import React, {useState} from 'react'
import $ from "jquery";

function ProfileDriver(){

    let url = "http://lidabusdiplom.by/controllers/driver/getNearestRoute.php"


    console.log(localStorage.getItem('ID'))


    let item = {
       ID: localStorage.getItem('ID')
    }



    // const [route, setRoute] = useState()

    $.ajax({
        xhrFields: {cors: false},
        mode: "no-cors",
        type: 'GET',
        url: url,
        data: {getNearestRouteByDriver: JSON.stringify(item)},
        dataType: 'json'
    }).done(function (response){
        console.log(response)
        // setRoute(response)
    })

    return(
        <>
        <p>user show routes</p>
        </>
            )


    return(
        <p>i am driver</p>
    )
}

export default ProfileDriver