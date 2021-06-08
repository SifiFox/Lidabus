import React, {useEffect, useState} from 'react'
import {BrowserRouter as Router, Link, Route, Switch} from "react-router-dom";
import User from "./User";
import $ from "jquery";

function UserShowRoutes(){

    let url = "http://lidabusdiplom.by/controllers/order/getOrdersByUser.php"


    console.log(localStorage.getItem('ID'))


    let item = {
        ID_User: localStorage.getItem('ID')
    }

    $.ajax({
        xhrFields: {cors: false},
        mode: "no-cors",
        type: 'POST',
        url: url,
        data: {getOrdersByUser: JSON.stringify(item)},
        dataType: 'json'
    }).done(function (response){
        console.log(response)
    })

    return(
        <p>user show routes</p>
    )

}

export default UserShowRoutes