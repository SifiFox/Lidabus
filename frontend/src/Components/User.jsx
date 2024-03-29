import React, {useState} from "react"
import {useHistory} from "react-router-dom";
import $ from "jquery";


    function User(props){
        const history = useHistory();
        const [PhoneNumber, setPhoneNumber] = useState(props.user.PhoneNumber)
        const [Surname, setSurname] = useState(props.user.Surname)
        const [Name, setName] = useState(props.user.Name)
        const [Patronymic, setPatronymic] = useState(props.user.Patronymic)
        const [ID, setID] = useState(props.user.id)
        const [Status, setStatus] = useState(props.user.Status)
        let user = {
            ID: ID,
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
        function handleStatus(){
                let userStatus = {
                ID_User:  ID,
                Status: Status
            }
            props.user.Status == 'Active' ? userStatus.Status = 'Blocked' : userStatus.Status = 'Active'
            let url = "http://lidabusdiplom.by/controllers/admin/users/updateUserStatus.php"
            $.ajax({
                type: 'POST',
                url: url,
                data: {updateUserStatus: JSON.stringify(userStatus)},
                dataType: 'json',
            }).done(function (response){
                setStatus(response.Status)
                console.log(response);
                pushHistory();
                alert('Ваш профиль обновлен');
            })
            console.log(user);
            alert("user saved");
        }
        function formCancel(){
            pushHistory();
            console.log('form cancel')
        }
    function userSave(){
            let url = "http://lidabusdiplom.by/controllers/user/update.php"
            $.ajax({
                type: 'POST',
                url: url,
                data: {updateUser: JSON.stringify(user)},
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
            <form className="edit--form user--edit--form">
                <label className="user--edit--form--label">Номер телефона</label>
                <input
                    className="user--edit--form--input"
                    type="text"
                    name="PhoneNumber"
                    placeholder={props.user.PhoneNumber}
                    onChange={handleInputChange}
                />
                <label className="user--edit--form--label">Фамилия</label>
                <input
                    className="user--edit--form--input"
                    type="text"
                    name="surname"
                    placeholder={props.user.Surname}
                    onChange={handleSurnameChange}
                    title="Введите корректные данные"
                />
                <label className="user--edit--form--label">Имя</label>
                <input
                    className="user--edit--form--input"
                    type="text"
                    name="name"
                    placeholder={props.user.Name}
                    onChange={handleNameChange}
                />
                <label className="user--edit--form--label">Отчество</label>
                <input
                    className="user--edit--form--input"
                    type="text"
                    name="patronymic"
                    placeholder={props.user.Patronymic}
                    onChange={handlePatronymicChange}
                />
                {
                    props.user.Status == "Active"
                        ? <button onClick={handleStatus}>Block</button>
                        : <button onClick={handleStatus}>Unblock</button>
                }
                <button className="user--edit--form--button"
                        onClick={userSave}>
                    Сохранить
                </button>

                <button className="user--edit--form--button"
                        onClick={formCancel}>
                    Отмена
                </button>
            </form>

        </>
        else
            return null
}

export default User

