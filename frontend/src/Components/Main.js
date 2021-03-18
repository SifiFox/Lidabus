import React from 'react';
import buspic from '../img/buspic.png'
import '../scss/main.scss'
import {Link} from "react-router-dom";
import Trust from "./Trust";
import Advantages from "./Advantages";

function Main(){
    return(
        <>
        <section className="main">
            <img className="main--pic" src={buspic} alt="" />

                <div className="main--description">
                    <h2>Лидская</h2>
                    <h1>Стрела</h1>
                </div>
        </section>

        <div className="main--offer">
            <div className="main--offer--sub">
                <div className="main--offer--sub--left">
                    <p className="main--offer--sub--left--description">
                        пассажирские перевозки
                        Лида-Минск/Минск-Лида
                    </p>
                </div>

                <div className="main--offer--sub--right">
                    <Link to={'/booking'} className="main--offer--sub--right--button">
                        <p className="main--offer--sub--right--button--link">
                            Забронировать
                        </p>
                    </Link>
                </div>
            </div>
        </div>

        <Trust/>
        <Advantages/>

    </>
    )
}

export default Main