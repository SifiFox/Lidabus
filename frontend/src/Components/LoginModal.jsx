import "../scss/modal.scss"

import {Link, useHistory} from "react-router-dom";

import cross from '../img/cross.png'


import { fadeIn } from 'react-animations';
import styled, { keyframes } from 'styled-components';
const Fade = styled.div`animation: 0.3s ${keyframes`${fadeIn}`} 1`;




const LoginModal = props => {

    const history = useHistory();

    function testHistory(){
       if(localStorage.getItem("Name")){
           history.push("/profile");
       }
    }


    return(
        <div className={`modal__wrapper ${props.isLoginOpened ? 'open' : 'close'}`} >

                <div className="modal__body">
                <div className="modal--outline"></div>
                <div className="modal--content--wrapper">

                    <div className="modal__close" onClick={props.onModalClose}>
                        <img src={cross} alt=""/>
                    </div>

                    <Fade>

                    <div className="modal--desc">
                        <h2>{props.title}</h2>
                    </div>


                    <form className="modal--input" method="post"
                        onSubmit={props.enterClick}
                        action="c"
                    >
                        <div className="input--wrapper">
                            <input id='phoneNumber' type="text" className="form--input" placeholder="Номер телефона"
                                   onChange={e => props.phoneNumberHandler(e)}
                            />
                        </div>

                        <div className="input--wrapper">
                            <input type="password" className="form--input" placeholder="Пароль"
                                   onChange={e => props.passwordHandler(e)}
                            />
                        </div>

                        <div className="regAuth--navigate">
                            <button className='main--button'
                                    onClick={testHistory}>
                                Войти
                            </button>

                            <Link

                                className='secondary--button'
                                onClick={props.switchToRegister}>
                                Регистрация
                            </Link>
                        </div>

                    </form>
                    {props.children}

                    <Link to={'/'} className="remember">
                        Забыли пароль?
                    </Link>
                </Fade>
                </div>
            </div>
        </div>
    )
}

export default LoginModal