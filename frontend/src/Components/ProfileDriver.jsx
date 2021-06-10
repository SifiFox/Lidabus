import React, {useEffect, useState} from 'react'
import $ from "jquery";
import {BrowserRouter as Router, Link, Route, Switch} from "react-router-dom";
import User from "./User";
import DriverRouteControl from "./DriverRouteCotrol";

function ProfileDriver(){

    let url = "http://lidabusdiplom.by/controllers/driver/getRoutesByDriverID.php"
    console.log(localStorage.getItem('ID'))
    let item = {
        ID: localStorage.getItem('ID')
    }


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
            type: 'GET',
            url: url,
            data: {getRoutesByDriverID: JSON.stringify(item)},
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
                                            <Link to={`/routes/route`} className="help--main--link"
                                                  onClick={handleClickEdit}
                                            >
                                                <p>текс</p>
                                            </Link>
                                        </button>
                                        {
                                            <div className="help-inner">
                                                <Switch>
                                                    <Route render={()=><DriverRouteControl route={item} isShowed={editShow.isShowed}/>} path={`/routes/route`}/>
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

export default ProfileDriver