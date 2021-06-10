import React, {useEffect, useState} from 'react'
import {BrowserRouter as Router, Link, Route, Switch} from "react-router-dom";
import AdminUsers from "./AdminUsers";
import AdminDrivers from "./AdminDrivers";
import AdminAutos from "./AdminAutos";
import AdminCreateUser from "./AdminCreateUser";
import RegisterModal from "./RegisterModal";

import $ from "jquery"
import LoginModal from "./LoginModal";
import CreatePromocodes from "./CreatePromocodes";
import PromocodesList from "./PromocodesList";
import AssignPromocode from "./AssignPromocode";

function AdminPanel(){

    const [PhoneNumber, setPhoneNumber] = useState({
        PhoneNumber: ''
    })

    const [Password, setPassword] = useState({
        password: ''
    })

    const [PasswordConfirm, setPasswordConfirm] = useState({
        passwordConfirm: ''
    })

    const [Name, setName] = useState({
        Name: ''
    })

    const [Surname, setSurname] = useState({
        Surname: ''
    })

    const [Patronymic, setPatronymic] = useState({
        Patronymic: ''
    })

    function phoneNumberHandler(e){
        setPhoneNumber(e.target.value)
    }

    function passwordHandler(e){
        setPassword(e.target.value)
    }

    function passwordConfirmHandler(e){
        setPasswordConfirm(e.target.value)
    }

     function nameHandler(e){
        setName(e.target.value) }

    function surnameHandler(e){
        setSurname(e.target.value)
    }
    function patronymicHandler(e){
        setPatronymic(e.target.value)
    }

    let item = {
        PhoneNumber,
        Password,
        PasswordConfirm,
        Name,
        Surname,
        Patronymic
    };

    console.log(item)


    function createUser(e){
        e.preventDefault()

        console.log(item)
        $.ajax({
            type: "POST",
            url:  "http://lidabusdiplom.by/controllers/user/registerController.php",
            data: {register: JSON.stringify(item)},
            dataType: "json",
            encode: true,
            complete: function (response){
                alert(response.statusText)
                console.log(response);
            }
        }).done(function (data) {
            console.log(data);
        });
    }


    return(
           <>
               <form className="modal--input" method="post">
                   <div className="input--wrapper">
                       <input id='phoneNumber' type="text" className="form--input" placeholder="Номер телефона"
                              onChange={e => phoneNumberHandler(e)}   />
                   </div>

                   <div className="input--wrapper">
                       <input type="password" className="form--input" placeholder="Пароль"
                              onChange={e => passwordHandler(e)}  />
                   </div>

                   <div className="input--wrapper">
                       <input type="password" className="form--input" placeholder="Подтвердить пароль"
                              onChange={e => passwordConfirmHandler(e)} />
                   </div>

                   <div className="input--wrapper">
                       <input id='name' type="text" className="form--input" placeholder="Имя пользователя"
                              onChange={e => nameHandler(e)}  />
                   </div>

                   <div className="input--wrapper">
                       <input id='surname' type="text" className="form--input" placeholder="Фамилия пользователя"
                              onChange={e => surnameHandler(e)} />
                   </div>

                   <div className="input--wrapper">
                       <input id='patronymic' type="text" className="form--input" placeholder="Отчество пользователя"
                              onChange={e => patronymicHandler(e)}  />
                   </div>

                   <div className="reg--navigate">
                       <button className='reg--button'
                               onClick={event => createUser(event)}
                       >
                           Зарегистрировать
                       </button>

                   </div>
               </form>



               <CreatePromocodes/>

               <AssignPromocode/>


            <Router>
               <button>
                   <Link to={'/profile'} className="help--main--link">
                       <p>users</p>
                   </Link>
               </button>


                <button>
                    <Link to={'/drivers'} className="help--main--link">
                        <p>drivers</p>
                    </Link>
                </button>


                <button>
                    <Link to={'/autos'} className="help--main--link">
                        <p>autos</p>
                    </Link>
                </button>

                <button>
                    <Link to={'/promocodes'} className="help--main--link">
                        <p>promocodes</p>
                    </Link>
                </button>


                <div className="help-inner">
                    <Switch>
                        <Route component={AdminUsers} path={'/profile'}/>
                        <Route component={AdminDrivers} path={'/drivers'}/>
                        <Route component={AdminAutos} path={'/autos'}/>
                        <Route component={PromocodesList} path={'/promocodes'}/>
                    </Switch>
                </div>
            </Router>

             </>
        )
}


export default AdminPanel
