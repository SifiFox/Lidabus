import "../scss/modal.scss"
import { fadeIn } from 'react-animations';
import {Link} from "react-router-dom";

import cross from '../img/cross.png'
import styled, { keyframes } from 'styled-components';
const Fade = styled.div`animation: 0.3s ${keyframes`${fadeIn}`} 1`;



const LoginModal = props => {

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


                    <form className="modal--input"
                        onSubmit={props.enterClick}
                    >
                        <div className="input--wrapper">
                            <input id='phone' type="text" className="form--input" placeholder="Номер телефона"
                                   onChange={e => props.phoneHandler(e)}
                            />
                        </div>

                        <div className="input--wrapper">
                            <input type="password" className="form--input" placeholder="Пароль"
                                   onChange={e => props.passwordHandler(e)}
                            />
                        </div>



                        <div className="regAuth--navigate">
                            <button className='main--button'
                            >
                                Войти
                            </button>

                            <Link
                                to={'/register'}
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