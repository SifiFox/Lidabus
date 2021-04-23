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


    const [phoneNumber, setphoneNumber] = useState({
        phoneNumber: ''
    })

    const [password, setpassword] = useState({
        password: ''
    })

    const [passwordConfirm, setpasswordConfirm] = useState({
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




    const loginCompile = () => {
        const dataComp = {
            phoneNumber, password

        }
        console.log( 'login compile' );
        // console.log( dataComp );

        // let url = "http://lidabusdiplom.by/controllers/user/authorizationController.php"
        //
        // try {
        //     const response = fetch( url, {
        //         mode: "no-cors",
        //         method: 'POST', // или 'PUT'
        //         body: JSON.stringify( dataComp ), // данные могут быть 'строкой' или {объектом}!
        //         headers: {
        //             'Content-Type': 'application/json'
        //         }
        //     } );
        // } catch (error) {
        //     console.error( 'Ошибка:'     );
        // }

    }




    const [modal, setModal] = useState({
        LoginModal: false,
        RegisterModal: false
    })



     function loginTest() {
        // let item = {
        //     phoneNumber,
        //     password
        // };
        // let url = "http://lidabusdiplom.by/controllers/user/authorizationController.php"
        //  console.log(item);
        //
        //
        // let test = JSON.stringify(item.phoneNumber + ", " + item.password );
        //
        // try {
        //     const response =  fetch( url, {
        //         mode: "no-cors",
        //         method: 'POST', // или 'PUT'
        //         body:
        //              JSON.stringify(test), // данные могут быть 'строкой' или {объектом}
        //         headers: {
        //             'Content-Type': 'application/json'
        //         }
        //     } );
        //     console.log('успех test: ', test );
        //     console.log('успех item: ', item );
        // } catch (error) {
        //     console.error( 'Ошибка:', error );
        // }


         let item = {
             phoneNumber,
             password
         };
         let url = "http://lidabusdiplom.by/controllers/user/authorizationController.php"
         console.log(item);


         let test = JSON.stringify(item.phoneNumber + ", " + item.password );

         try {
             const response =  fetch( url, {
                 mode: "no-cors",
                 method: 'POST', // или 'PUT'
                 body:
                     JSON.stringify(item.phoneNumber), // данные могут быть 'строкой' или {объектом}
                 headers: {
                     'Content-Type': 'application/json'
                 }
             } );
             console.log('успех test: ', test );
             console.log('успех item: ', item );
         } catch (error) {
             console.error( 'Ошибка:', error );
         }


    }

    function registerTest(){
        let item = {
            name,
            phoneNumber,
            password,
            passwordConfirm};
        let url = "http://lidabusdiplom.by/controllers/user/registerController.php"

        try {
            const response =  fetch( url, {
                mode: "no-cors",
                method: 'POST', // или 'PUT'
                body: JSON.stringify( item ), // данные могут быть 'строкой' или {объектом}!
                headers: {
                    'Content-Type': 'application/json'
                }
            } );
            const json =  response.data;
            console.log( 'Успех:', JSON.stringify( json ) );
        } catch (error) {
            console.error( 'Ошибка:', error );
        }
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
                setphoneNumber(e.target.value);
                setpassword(e.target.value);
                loginCompile();
                loginTest();
            }}

            phoneNumberHandler={
                (e) => {
                    setphoneNumber(e.target.value)
                }}

            passwordHandler={
                (e) => {
                    setpassword(e.target.value)
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
                setphoneNumber(e.target.value)
            }}

        passwordHandler={
            (e) => {
                setpassword(e.target.value)
            }}

        passwordConfirmHandler={
            (e) => {
                setpasswordConfirm(e.target.value)
            }}

        enterClick={(e) =>{
            console.log('enter click')
            e.preventDefault();
            setphoneNumber(e.target.value);
            setpassword(e.target.value);
            registerTest();
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
