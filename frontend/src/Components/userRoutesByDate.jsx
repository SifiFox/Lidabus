import React, {useEffect, useState} from 'react'
import $ from "jquery";
import {BrowserRouter as Router, Link, Route, Switch} from "react-router-dom";
import RouteOrder from "./RouteOrder";
import UserCurrentOrders from "./UserCurrentOrders";
import UserOrderDetails from "./UserOrderDetails";

function UserRoutesByDate(props){




    console.log(props)

    const [error, setError] = useState(null);
    const [isLoaded, setIsLoaded] = useState(false);
    const [items, setItems] = useState([]);

    const [editShow, setEditShow] = useState({
        isShowed: false});

    function handleClickEdit(){
        editShow.isShowed == false ? setEditShow({isShowed: true}) : setEditShow({isShowed: false})
    }

    let initShow = false
    const [detailsShow, setDetailsShow] = useState(initShow)

    function handleDetailsShow(){
        initShow = !initShow
        setDetailsShow(initShow)
    }



    let url = "http://lidabusdiplom.by/controllers/order/getUserOrdersByDate.php"
    useEffect(() => {
        $.ajax({
            xhrFields: {cors: false},
            mode: "no-cors",
            type: 'POST',
            url: url,
            data: {getUserOrdersByDate: JSON.stringify(props.item)},
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
                                {item.Mark} {item.Destination}
                            </li>
                            <Router>

                                <button>
                                    <Link to={`/details`} className="help--main--link"
                                          onClick={handleDetailsShow}>
                                        <p>Детально</p>
                                    </Link>
                                </button>
                                {
                                    <div className="help-inner" >
                                            {/*<UserOrderDetails  className={detailsShow ? "visible" : "hidden"}/>*/}
                                            {/*<UserOrderDetails route={item} shown={detailsShow}/>*/}
                                        <Switch>
                                            <Route render={()=><UserOrderDetails route={item} shown={detailsShow}/>} path={`/details`}/>
                                        </Switch>
                                    </div>
                                }


                                {/*{*/}
                                {/*    <div className="help-inner">*/}
                                {/*        <Switch>*/}
                                {/*            <Route render={()=><RouteOrder route={item} isShowed={editShow.isShowed}/>} path={`/route`}/>*/}
                                {/*        </Switch>*/}
                                {/*    </div>*/}
                                {/*}*/}
                            </Router>
                        </>
                    ))}
            </ul>
        );}
}

export default UserRoutesByDate