import React, {useState, useEffect} from 'react';
import '../src/scss/header.scss'
import '../src/reset.css'
import '../src/scss/_fonts.scss'
import '../src/scss/modal.scss'
import '../src/scss/general.scss'

import $ from "jquery"


import InnerMenu from "./Components/InnerMenu";
import Nav from "../src/Components/Header"
import Main from "./Components/Main";
import {Redirect, Route, Switch} from "react-router-dom";
import Booking from "./Components/Booking";
import Help from "./Components/Help";
import Footer from "./Components/Footer";



import LoginModal from "./Components/LoginModal";
import RegisterModal from "./Components/RegisterModal";
import Profile from "./Components/Profile";




function App() {



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
    const [Role, setRole] = useState({
        Role: ''
    })
    const [Rating, setRating] = useState({
        Rating: ''
    })

    const [modal, setModal] = useState({
        LoginModal: false,
        RegisterModal: false
    })
    const [ID, setID] = useState({
        ID: ''
    })



      async function loginTest() {
          let item = {
              ID,
              PhoneNumber,
              Password,
              Name,
          };
          let url = "http://lidabusdiplom.by/controllers/user/authorizationController.php"

          $.ajax({
              type: 'GET',
              url: url,
              data: {auth: JSON.stringify(item)},
              dataType: 'json',
              complete: function (response){

                  // let obj = JSON.parse(response.responseText);

                  console.log(response);

                  let obj = JSON.parse(response.responseText);


                  console.log(obj);

                  setID(obj.ID)
                  setPhoneNumber(obj.PhoneNumber);
                  setName(obj.Name);
                  setSurname(obj.Surname);
                  setPatronymic(obj.Patronymic);
                  setPatronymic(obj.Role);
                  setRating(obj.Rating);

                  localStorage.setItem('ID', obj.ID);
                  localStorage.setItem('PhoneNumber', obj.PhoneNumber);
                  localStorage.setItem('Name', obj.Name);
                  localStorage.setItem('Surname', obj.Surname) ;
                  localStorage.setItem('Patronymic', obj.Patronymic);
                  localStorage.setItem('Role', obj.Role);
                  localStorage.setItem('Rating', obj.Rating);


                  // console.log('obj number ' + obj.PhoneNumber);
                  // console.log('obj Name ' + obj.Name);

                  console.log(localStorage.getItem("ID"))
                  console.log(localStorage.getItem("Name"))
                  console.log(localStorage.getItem("PhoneNumber"))
                  console.log(localStorage.getItem("Surname"))
                  console.log(localStorage.getItem("Patronymic"))
                  console.log(localStorage.getItem("Role"))
                  console.log(localStorage.getItem("Rating"))

                  setModal(LoginModal, false)
              }
          }).done(function (){
              alert('Вы успешно авторизированы');
          })



    }

    function registerTest(){
        let item = {
            PhoneNumber,
            Password,
            PasswordConfirm,
            Name,
            Surname,
            Patronymic
        };
        let url = "http://lidabusdiplom.by/controllers/user/registerController.php"

        $.ajax({
            xhrFields: {cors: false},
            mode: "no-cors",
            type: 'POST',
            url: url,
            data: {register: JSON.stringify(item)},
            dataType: 'json',
            complete: function (response){
                let obj = JSON.parse(response.responseText);
                console.log(obj);
                alert(obj.answer);
                setModal(LoginModal, false)
            }

        })

    }


    return (
        <>

        <Nav/>

        <LoginModal
            title={'Логин'}
            isLoginOpened={modal.LoginModal}


            switchToRegister={() =>
                setModal({
                ...modal,
                LoginModal: false,
                RegisterModal: true
            }
            )}
            onModalClose={()=> setModal({
                ...modal,
                LoginModal: false,
                RegisterModal: false
            }
            )}

            enterClick={(e) =>{
                console.log('enter click')
                e.preventDefault();
                setPhoneNumber(e.target.value);
                setPassword(e.target.value);
                loginTest();

                console.log(localStorage.getItem('Surname') + ' surname')

                var inputs = document.querySelectorAll('input[type=text], input[type=password]');
                for (var i = 0;  i < inputs.length; i++) {
                    inputs[i].value = '';
                };
            }}

            phoneNumberHandler={
                (e) => {
                    setPhoneNumber(e.target.value)
                }}

            passwordHandler={
                (e) => {
                    setPassword(e.target.value)
                }}
        />


        <RegisterModal
        title={'Регистрация'}
        isRegisterOpened={modal.RegisterModal}

        onModalClose={()=> setModal({
                ...modal,
                LoginModal: false,
                RegisterModal: false
            }
        )}



        phoneNumberHandler={
            (e) => {
                setPhoneNumber(e.target.value)
            }}

        passwordHandler={
            (e) => {
                setPassword(e.target.value)
            }}

        passwordConfirmHandler={
            (e) => {
                setPasswordConfirm(e.target.value)
            }}

        nameHandler={
            (e) => {
                setName(e.target.value)
            }}

        surnameHandler={
            (e) => {
                setSurname(e.target.value)
            }}

        patronymicHandler={
            (e) => {
                setPatronymic(e.target.value)
            }}


        enterClick={(e) =>{
            console.log('enter click')
            e.preventDefault();
            setPhoneNumber(e.target.value);
            setPassword(e.target.value);
            setPasswordConfirm(e.target.value);
            setName(e.target.value);
            setSurname(e.target.value);
            setPatronymic(e.target.value);
            registerTest();
            // registerCompile();
        }}

        switchToLogin={() => setModal({
                ...modal,
                LoginModal: true,
                RegisterModal: false
            }
        )}
        />


            <InnerMenu
                loginToggle={() => setModal({
                    ...modal,
                    LoginModal: true,
                })
                }

            />



        <div className="auth-wrapper">
            <div className="auth-inner">
                <Switch>
                    <Route exact path={"/"} component={Main}/>
                    <Route exact path={"/booking"} component={Booking}/>
                    <Route exact path={"/help"} component={Help}/>
                    <Route exact path={"/contacts"} component={Help}/>
                    <Route exact path={"/partners"} component={Help}/>
                    <Route exact path={"/profile"} component={Profile}/>
                </Switch>
            </div>
        </div>







            <Footer/>
        </>
        )
}

export default App;
