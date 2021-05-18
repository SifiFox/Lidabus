import React, {useState} from 'react'

import '../scss/userEditForm.scss'
import $ from "jquery";
import LoginModal from "./LoginModal";



function UserEditForm(){


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




    function userSave(){
        //
        // console.log(item.phone + " item phone.PhoneNumber  userSave");
        // // item.phone = PhoneNumber;
        // localStorage.setItem("PhoneNumber", PhoneNumber);
        // console.log(item.phone + " item.phone.PhoneNumber  UserSave");
        // console.log(localStorage.getItem("PhoneNumber") + " localstore.PhoneNumber  UserSave");
        // console.log(localStorage.getItem("Surname") + " localstore.PhoneNumber  UserSave");
        // console.log(PhoneNumber + " PhoneNumber.PhoneNumber  UserSave");
        // console.log(Surname + " PhoneNumber.PhoneNumber  UserSave");
        // console.log(Name + " PhoneNumber.PhoneNumber  UserSave");
        // console.log(Patronymic + " PhoneNumber.PhoneNumber  UserSave");

        let url = "http://lidabusdiplom.by/controllers/user/update.php"

        $.ajax({
            type: 'POST',
            url: url,
            data: {updateUser: JSON.stringify(item)},
            dataType: 'json',
            complete: function (response){

                let obj = JSON.parse(response.responseText);
                console.log(obj);

                // setPhoneNumber(obj.PhoneNumber);
                //
                // localStorage.setItem('PhoneNumber', obj.PhoneNumber);

                // console.log('obj number ' + obj.PhoneNumber);
                // console.log(localStorage.getItem("Name"))

            }
        }).done(function (){
            alert('Вы успешно авторизированы');
        })





        console.log(item);
        alert("user saved");
    }

    function formCancel(){
        console.log('form cancel')
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


        </form>

            <div className="useform">

                <button className="user--edit--form--button"
                        onClick={userSave}>
                    Сохранить
                </button>

                <button className="user--edit--form--button"
                        onClick={formCancel}>
                    Отмена
                </button>
            </div>

        </>

    )
}


export default UserEditForm