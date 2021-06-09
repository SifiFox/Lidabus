import React, {useEffect, useState} from 'react'
import {BrowserRouter as Router, Link, Route, Switch} from "react-router-dom";
import User from "./User";
import UserEditForm from "./UserEditForm";
import CreateDriver from "./CreateDriver";

function AdminDrivers(){


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
        fetch("http://lidabusdiplom.by/controllers/admin/drivers/getDrivers.php")
            .then(res => res.json())
            .then(
                (result) => {
                    setIsLoaded(true);
                    setItems(result);
// console.log(result);
                },
                (error) => {
                    setIsLoaded(true);
                    setError(error);
                }
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
                                        {item.PhoneNumber} {item.Surname} {item.Name} {item.Patronymic}
                                    </li>
                                    <Router>
                                        <button className='admin-edit'>
                                            <Link to={`/users/{item.ID}`} className="help--main--link"
                                                  onClick={handleClickEdit}
                                            >
                                                <p>редактировать</p>
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


export default AdminDrivers