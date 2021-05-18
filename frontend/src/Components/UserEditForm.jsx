import React, {useState} from 'react'

import '../scss/userEditForm.scss'
import $ from "jquery";
import LoginModal from "./LoginModal";
import {useHistory} from "react-router-dom";



function UserEditForm(handleHideClick){


    const [PhoneNumber, setPhoneNumber] = useState(localStorage.getItem("PhoneNumber"))
    const [Surname, setSurname] = useState(localStorage.getItem("Surname"))
    const [Name, setName] = useState(localStorage.getItem("Name"))
    const [Patronymic, setPatronymic] = useState(localStorage.getItem("Patronymic"))
    const [ID, setID] = useState(localStorage.getItem("ID"))


    let item = {
        ID: ID,
        PhoneNumber: PhoneNumber,
        Surname: Surname,
        Name: Name,
        Patronymic: Patronymic
    }


    function handleInputChange(e){
        e.preventDefault();
        setPhoneNumber(e.target.value);
        console.log(PhoneNumber + " after change inputChange");
    }

    function handleSurnameChange(e){
        e.preventDefault();
        setSurname(e.target.value)
        console.log(Surname + " after change inputChange");
    }

    function handleNameChange(e){
        e.preventDefault();
        setName(e.target.value)
        console.log(Name + " after change inputChange");
    }

    function handlePatronymicChange(e){
        e.preventDefault();
        setPatronymic(e.target.value)
        console.log(Patronymic + " after change inputChange");
    }


    const history = useHistory();

    function testHistory(){
        if(localStorage.getItem("Name")){
            history.push("/profile");
        }
    }



    function userSave(){

        let url = "http://lidabusdiplom.by/controllers/user/update.php"

        $.ajax({
            type: 'POST',
            url: url,
            data: {updateUser: JSON.stringify(item)},
            dataType: 'json',
            complete: function (response){

                let obj = JSON.parse(response.responseText);
                console.log(obj);


                setPhoneNumber(obj.PhoneNumber);
                setName(obj.Name);
                setSurname(obj.Surname);
                setPatronymic(obj.Patronymic);


                localStorage.setItem('PhoneNumber', obj.PhoneNumber);
                localStorage.setItem('Name', obj.Name);
                localStorage.setItem('Surname', obj.Surname) ;
                localStorage.setItem('Patronymic', obj.Patronymic);


                testHistory();
            }
        }).done(function (){
            alert('Вы успешно авторизированы');
        })





        console.log(item);
        alert("user saved");
    }

    function formCancel(){
        console.log('form cancel');
        return null;
    }

    return(
        <>
        <form className="edit--form user--edit--form">

            <label className="user--edit--form--label">Номер телефона</label>
            <input
                className="user--edit--form--input"
                type="text"
                name="PhoneNumber"
                placeholder={localStorage.getItem("PhoneNumber")}
                // value={localStorage.getItem("PhoneNumber")}
                onChange={handleInputChange}
            />

            <label className="user--edit--form--label">Фамилия</label>
            <input
                className="user--edit--form--input"
                type="text"
                name="surname"
                placeholder={localStorage.getItem("Surname")}
                onChange={handleSurnameChange}
                pattern="^[A-Za-z]{4,}"
                title="Введите корректные данные"
            />

            <label className="user--edit--form--label">Имя</label>
            <input
                className="user--edit--form--input"
                type="text"
                name="name"
                placeholder={localStorage.getItem("Name")}
                onChange={handleNameChange}
            />


            <label className="user--edit--form--label">Отчество</label>
            <input
                className="user--edit--form--input"
                type="text"
                name="patronymic"
                placeholder={localStorage.getItem("Patronymic")}
                onChange={handlePatronymicChange}
            />

            <button className="user--edit--form--button"
                    onClick={formCancel}>
                Отмена
            </button>
        </form>

            <div className="useform">

                <button className="user--edit--form--button"
                        onClick={userSave}>
                    Сохранить
                </button>


            </div>

        </>

    )
}


export default UserEditForm