import React, {useState} from 'react'
import {useHistory} from "react-router-dom";
import $ from "jquery";

function DriverRouteControl(props){
    const history = useHistory();
    const [PhoneNumber, setPhoneNumber] = useState(props.route.PhoneNumber)
    const [Surname, setSurname] = useState(props.route.Surname)
    const [Name, setName] = useState(props.route.Name)
    const [Patronymic, setPatronymic] = useState(props.route.Patronymic)
    const [Route_ID, setRoute_ID] = useState(props.route.Route_ID)
    const [Status, setStatus] = useState(props.route.Status)
    let route = {
        ID: Route_ID,
        PhoneNumber: PhoneNumber,
        Surname: Surname,
        Name: Name,
        Patronymic: Patronymic,
        Status: Status
    }
    function pushHistory(){
        history.push("/profile");
        window.location.reload();
    }
    function handleInputChange(e){
        e.preventDefault();
        setPhoneNumber(e.target.value);
        console.log(" after change inputChange");
    }
    function handleSurnameChange(e){
        e.preventDefault();
        setSurname(e.target.value);
        console.log(" after change inputChange");
    }
    function handleNameChange(e){
        e.preventDefault();
        setName(e.target.value);
        console.log("after change inputChange");
    }
    function handlePatronymicChange(e){
        e.preventDefault();
        setPatronymic(e.target.value);
        console.log(" after change inputChange");
    }
    function handleStatusToInWay(){
        let routeStatus = {
            ID_Route:  Route_ID,
            Status: "В пути"
        }
        let url = "http://lidabusdiplom.by/controllers/driver/updateRouteStatusToInWay.php"
        $.ajax({
            type: 'POST',
            url: url,
            data: {updateRouteStatusToInWay: JSON.stringify(routeStatus)},
            dataType: 'json',
        }).done(function (response){
            setStatus(response.Status)
            console.log(response);
            pushHistory();
            alert('Статус поездки обновлен');
        })
        console.log(route);
        alert("route saved");
    }

    function handleStatusToArrived(){
        let routeStatus = {
            ID_Route:  Route_ID,
            Status: "Прибыл"
        }
        let url = "http://lidabusdiplom.by/controllers/driver/updateRouteStatusToArrived.php"
        $.ajax({
            type: 'POST',
            url: url,
            data: {updateRouteStatusToArrived: JSON.stringify(routeStatus)},
            dataType: 'json',
        }).done(function (response){
            setStatus(response.Status)
            console.log(response);
            pushHistory();
            alert('Статус поездки обновлен');
        })
        console.log(route);
        alert("route saved");
    }


    function formCancel(){
        pushHistory();
        console.log('form cancel')
    }
    function routeSave(){
        let url = "http://lidabusdiplom.by/controllers/route/update.php"
        $.ajax({
            type: 'POST',
            url: url,
            data: {updateroute: JSON.stringify(route)},
            dataType: 'json',
        }).done(function (response){
            console.log(response);
            setPhoneNumber(response.PhoneNumber);
            setName(response.Name);
            setSurname(response.Surname);
            setPatronymic(response.Patronymic);
            pushHistory();
            alert('Ваш профиль обновлен');
        })
    }
    if(props.isShowed)
        return  <>
            <form className="edit--form route--edit--form">

                <label className="route--edit--form--label">Отчество</label>
                <input
                    className="route--edit--form--input"
                    type="text"
                    name="patronymic"
                    placeholder={props.route.Patronymic}
                    onChange={handlePatronymicChange}
                />
                {
                    props.route.Status == "В ожидании"
                        ? <button onClick={handleStatusToInWay}>В пути</button>
                        : <button onClick={handleStatusToArrived}>Прибыл</button>
                }
                <button className="route--edit--form--button"
                        onClick={routeSave}>
                    Сохранить
                </button>

                <button className="route--edit--form--button"
                        onClick={formCancel}>
                    Отмена
                </button>
            </form>

        </>
    else
        return null
}

export default DriverRouteControl