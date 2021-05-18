import React from "react"
import "../scss/contactUs.scss"
import cross from "../img/cross.png";
import "../scss/modal.scss"
import googlePlay from "../img/googlePlay.png"
import appStore from "../img/appStore.png"




import { fadeIn } from 'react-animations';
import styled, { keyframes } from 'styled-components';
import {Link} from "react-router-dom";
const Fade = styled.div`animation: 0.3s ${keyframes`${fadeIn}`} 1`;


function ContactUs(){
    return(
        <>
            <div className="contactUs--wrap">

                <div className="contactUs--form--wrap">

                    <h1>СВЯЗАТЬСЯ С НАМИ</h1>

                    <div className="modal__wrapper contactUs">
                        <div className="modal__body">
                            <div className="modal--outline"></div>
                            <div className="modal--content--wrapper">

                                <Fade>
                                    <div className="modal--desc">
                                        <h2>Заказать звонок</h2>
                                    </div>


                                    <form className="modal--input" method="post" action="c">
                                        <div className="input--wrapper">
                                            <input id='name' type="text" className="form--input" placeholder="Ваше имя"/>
                                        </div>

                                        <div className="input--wrapper">
                                            <input id='phoneNumber' type="text" className="form--input" placeholder="Номер телефона"/>
                                        </div>


                                        <div className="regAuth--navigate">
                                            <button className='main--button'>
                                                Заказать
                                            </button>

                                        </div>

                                    </form>
                                </Fade>
                            </div>
                        </div>
                    </div>


                </div>

                <div className="contactUs--app--wrap">
                    <h1>СВЯЗАТЬСЯ С НАМИ</h1>
                    <div className="contactUs--app">
                        <div className="stores--links">

                            <div className="stores--link">
                                <img src={googlePlay} alt=""/>
                            </div>


                            <div className="stores--link">
                                <img src={appStore} alt=""/>
                            </div>


                            
                        </div>


                        <Link to={'/booking'} className="main--offer--sub--right--button">
                            <p className="main--offer--sub--right--button--link">
                                Забронировать
                            </p>
                        </Link>

                    </div>
                </div>

            </div>
        </>
    )
}

export default ContactUs