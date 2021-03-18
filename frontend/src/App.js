import React, {useState, useEffect} from 'react';
import '../src/scss/header.scss'
import '../src/reset.css'
import '../src/scss/_fonts.scss'
import '../src/scss/modal.scss'
import '../src/scss/general.scss'


import InnerMenu from "./Components/InnerMenu";
import Nav from "../src/Components/Header"
import Main from "./Components/Main";
import {Route,  Switch} from "react-router-dom";
import Booking from "./Components/Booking";
import Help from "./Components/Help";
import Footer from "./Components/Footer";



import LoginModal from "./Components/LoginModal";
import RegisterModal from "./Components/RegisterModal";



function App() {


    const [phone, setPhone] = useState({
        phone: ''
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
            phone,
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




    const loginCompile = () => {
        const dataComp = {
            phone,
            password

        }
        console.log('login compile');
        console.log(dataComp);
    }




    const [modal, setModal] = useState({
        LoginModal: false,
        RegisterModal: false
    })



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
                setPhone(e.target.value);
                setPassword(e.target.value);
                loginCompile();
            }}

            phoneHandler={
                (e) => {
                    setPhone(e.target.value)
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

        phoneHandler={
            (e) => {
                setPhone(e.target.value)

                console.log(e)
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
            setPhone(e.target.value);
            setPassword(e.target.value);
            registerCompile();
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
                </Switch>
            </div>
        </div>


            <Footer/>
        </>




        )
}

export default App;
