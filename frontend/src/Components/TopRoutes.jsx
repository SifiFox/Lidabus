import React, {useEffect, useState} from 'react'
import {BrowserRouter as Router, Link, Route, Switch} from "react-router-dom";
import $ from "jquery";
import RouteOrder from "./RouteOrder";


function TopRoutes(props){


    const [error, setError] = useState(null);
    const [isLoaded, setIsLoaded] = useState(false);
    const [items, setItems] = useState([]);


    const [editShow, setEditShow] = useState({
        isShowed: false
    });

    function handleClickEdit(){
        editShow.isShowed == false ? setEditShow({isShowed: true}) : setEditShow({isShowed: false})
    }


    let item = {
        Destination: props.Destination
    };

    let url = "http://lidabusdiplom.by/controllers/route/getNearestThreeRoute.php"

    useEffect(() => {
        $.ajax({
            xhrFields: {cors: false},
            mode: "no-cors",
            type: 'GET',
            url: url,
            data: {getDestination: JSON.stringify(item)},
            dataType: 'json',
        })
            .then(
                (result) => {
                    setIsLoaded(true);
                    setItems(result);
                    console.log(result);
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
            <ul>
                {
                    items.map(item => (
                        <>
                            <li key={item.ID}>
                                {item.PhoneNumber} {item.Destination}
                            </li>
                            <Router>

                                <button>
                                    <Link to={`/route`} className="help--main--link"
                                          onClick={handleClickEdit}>
                                        <p>Заказать</p>
                                    </Link>
                                </button>
                                {
                                    <div className="help-inner">
                                        <Switch>
                                            <Route render={()=><RouteOrder route={item} isShowed={editShow.isShowed}/>} path={`/route`}/>
                                        </Switch>
                                    </div>
                                }
                            </Router>
                        </>
                    ))}
            </ul>

        );
    }




    // useEffect(() => {
    //     fetch("http://lidabusdiplom.by/controllers/admin/users/getUsers.php")
    //         .then(res => res.json())
    //         .then(
    //             (result) => {
    //                 setIsLoaded(true);
    //                 setItems(result);
    //                 // console.log(result);
    //             },
    //             (error) => {
    //                 setIsLoaded(true);
    //                 setError(error);
    //             }
    //         )
    // }, [])
    //
    // if (error) {
    //     return <div>Ошибка: {error.message}</div>;
    // } else if (!isLoaded) {
    //     return <div>Загрузка...</div>;
    // } else {
    //     return (
    //         <ul>
    //             {
    //                 items.map(item => (
    //                     <>
    //                         <li key={item.ID}>
    //                             {item.PhoneNumber} {item.Surname} {item.Name} {item.Patronymic}
    //                         </li>
    //                         <Router>
    //                             <button>
    //                                 <Link to={`/users/{item.ID}`} className="help--main--link"
    //                                       onClick={handleClickEdit}
    //                                 >
    //                                     <p>edit</p>
    //                                 </Link>
    //                             </button>
    //                             {
    //                                 <div className="help-inner">
    //                                     <Switch>
    //                                         <Route   render={()=><User user={item} isShowed={editShow.isShowed}/>} path={`/users/{item.ID}`}/>
    //                                     </Switch>
    //                                 </div>
    //                             }
    //                         </Router>
    //                     </>
    //                 ))}
    //         </ul>
    //
    //     );
    // }

}


export default TopRoutes
