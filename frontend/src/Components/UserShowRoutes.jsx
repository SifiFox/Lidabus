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



    const [error, setError] = useState(null);
    const [isLoaded, setIsLoaded] = useState(false);
    const [items, setItems] = useState([]);


    const [editShow, setEditShow] = useState({
        isShowed: false
    });

    function handleClickEdit(){
        editShow.isShowed == false ? setEditShow({isShowed: true}) : setEditShow({isShowed: false})
    }

    useEffect(() => {
        $.ajax({
            xhrFields: {cors: false},
            mode: "no-cors",
            type: 'POST',
            url: url,
            data: {getOrdersByUser: JSON.stringify(item)},
            dataType: 'json'
        }).done(
                (result) => {
                    console.log(result)
                    setIsLoaded(true);
                    setItems(result);
                },
            )
    }, [])

    if (error) {
        return <div>Ошибка: {error.message}</div>;
    } else if (!isLoaded) {
        return <div>Загрузка...</div>;
    } else {
        return (
            <>
                <ul>
                    {
                        items.map(item => (
                            <>
                                <div className='help-inner-admin-profile'>
                                    <li key={item.ID}>
                                        {item.Date} {item.StartTreepTime} {item.EndTreepTime} {item.GovernmentNumber} {item.Patronymic}
                                    </li>
                                    <Router>
                                        <button className='admin-edit'>
                                            <Link to={`/users/{item.ID}`} className="help--main--link"
                                                  onClick={handleClickEdit}
                                            >
                                                <p>Подробнее</p>
                                            </Link>
                                        </button>
                                        {
                                            <div className="help-inner">
                                                <Switch>
                                                    <Route render={()=><User user={item} isShowed={editShow.isShowed}/>} path={`/users/{item.ID}`}/>
                                                </Switch>
                                            </div>
                                        }
                                    </Router>
                                </div>
                            </>
                        ))}
                </ul>
            </>
        );
    }

}

export default UserShowRoutes