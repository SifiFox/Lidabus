import React, {useState, useEffect} from 'react';
import '../src/scss/header.scss'
import '../src/reset.css'
import '../src/scss/_fonts.scss'
import '../src/scss/modal.scss'
import '../src/scss/general.scss'
import axios from "axios";

import $ from "jquery"


import InnerMenu from "./Components/InnerMenu";
import Nav from "../src/Components/Header"
import Main from "./Components/Main";
import {Route,  Switch} from "react-router-dom";
import Booking from "./Components/Booking";
import Help from "./Components/Help";
import Footer from "./Components/Footer";



import LoginModal from "./Components/LoginModal";
import RegisterModal from "./Components/RegisterModal";
import context from "react-router/modules/RouterContext";
import Profile from "./Components/Profile";




function App() {


    const [phoneNumber, setPhoneNumber] = useState({
        phoneNumber: ''
    })

    const [password, setPassword] = useState({
        password: ''
    })

    const [passwordConfirm, setPasswordConfirm] = useState({
        passwordConfirm: ''
    })

    const [name, setName] = useState({
        name: ''
    })


    const registerCompile = () => {
        const dataComp = {
            name,
            phoneNumber,
            password,
            passwordConfirm
        }



        console.log(dataComp);
    }


    useEffect(() => {
        loadData()
    }, [])

    const loadData = () => {
        fetch("http://lidabusdiplom.by/")
            .then(response => {
               console.log(response)
            })
    }


    const [modal, setModal] = useState({
        LoginModal: false,
        RegisterModal: false
    })



      async function loginTest() {
          let item = {
              phoneNumber,
              password
          };
          let url = "http://lidabusdiplom.by/controllers/user/authorizationController.php"

          $.ajax({
              type: 'POST',
              url: url,
              data: {auth: JSON.stringify(item)},
              dataType: 'json'
          });
    }

    function registerTest(){
        let item = {
            name,
            phoneNumber,
            password,
            passwordConfirm
        };

        let url = "http://lidabusdiplom.by/controllers/user/registerController.php"

        $.ajax({
            type: 'POST',
            url: url,
            data: {register: JSON.stringify(item)},
            dataType: 'json'
        });
    }


    return (
        <>

        <InnerMenu
            loginToggle={() => setModal({
                ...modal,
                LoginModal: true,
            })
            }
        />

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
                // loginCompile();
                loginTest();
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

        nameHandler={
            (e) => {
                setName(e.target.value)
            }}

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

        enterClick={(e) =>{
            console.log('enter click')
            e.preventDefault();
            setName(e.target.value);
            setPhoneNumber(e.target.value);
            setPassword(e.target.value);
            setPasswordConfirm(e.target.value);
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
