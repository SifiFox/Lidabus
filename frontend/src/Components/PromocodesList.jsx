import React, {useEffect, useState} from 'react'
import {BrowserRouter as Router, Link, Route, Switch} from "react-router-dom";
import User from "./User";

function PromocodesList(){
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
        fetch("http://lidabusdiplom.by/controllers/promocode/getPromocodes.php")
            .then(res => res.json())
            .then(
                (result) => {
                    setIsLoaded(true);
                    setItems(result);
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
                                {item.ID} {item.Promocode} {item.Name} {item.Sale}
                            </li>
                        </>
                    ))}
            </ul>
        );
    }
}

export default PromocodesList