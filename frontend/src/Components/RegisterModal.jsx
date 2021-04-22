import "../scss/modal.scss"
import {Link} from "react-router-dom";

import { fadeIn } from 'react-animations';
import styled, { keyframes } from 'styled-components';
import cross from "../img/cross.png";
const Fade = styled.div`animation: 0.3s ${keyframes`${fadeIn}`} 1`;




const RegisterModal = props => {



    return (
        <div className={`modal__wrapper ${props.isRegisterOpened ? 'open' : 'close'}`}>
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
                                <input id='name' type="text" className="form--input" placeholder="Ваше имя"
                                       onChange={e => props.nameHandler(e)}
                                />
                            </div>

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

                            <div className="input--wrapper">
                                <input type="password" className="form--input" placeholder="Подтвердить пароль"
                                       onChange={e => props.passwordConfirmHandler(e)}
                                />
                            </div>


                            <div className="reg--navigate">
                                <button className='reg--button'

                                >
                                    Зарегистрироваться
                                </button>

                                <Link
                                    className='reg--secondary--button'
                                    onClick={props.switchToLogin}>
                                    У меня уже есть аккаунт
                                </Link>
                            </div>
                        </form>



                        {props.children}

                        </Fade>

                    </div>

                </div>



        </div>


    )
}

export default RegisterModal