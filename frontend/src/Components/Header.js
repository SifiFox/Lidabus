import React from 'react';
import '../scss/header.scss'
import logo from "../img/logo.png"
import aone from "../img/a1.png"
import mts from "../img/mts.png"
import life from "../img/life.png"
import {Link} from "react-router-dom";


function Nav() {
    return (
        <header>
            <div className="nav--wrap">
                <nav className="nav">
                   <Link to={'/'}>
                       <img className="logo" src={ logo } alt=""/>
                   </Link>

                    <ul className="nav--links">
                        <li className="nav--link">
                            <Link to={"/"}>Главная</Link>
                        </li>

                        <li className="nav--link">
                            <Link to={"/booking"}>
                                Бронирование
                            </Link>
                        </li>

                        <li className="nav--link">
                            <Link to={'/help'}>
                                Помощь
                            </Link>
                        </li>
                    </ul>

                    <ul className="telephone">
                        <li className="telephone--left">
                            <img className="operator--logo" src={ life } alt=""/>
                            <img className="operator--logo" src={ aone } alt=""/>
                            <img className="operator--logo" src={ mts } alt=""/>
                            <p>794-10-00</p>
                        </li>


                        <li className="telephone--right">
                            <img className="operator--logo" src={ aone } alt=""/>
                            <img className="operator--logo" src={ mts } alt=""/>
                            <div className="telephone--vertical">
                                <p>594-10-00</p>
                                <p>394-10-00</p>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>

            <div className="hamburger-menu">
                <input id="menu__toggle" type="checkbox"/>
                <label className="menu__btn" htmlFor="menu__toggle">
                    <span></span>
                </label>

                <ul className="menu__box">
                    <li><Link className="menu__item" to={'/'}>Главная</Link></li>
                    <li><Link className="menu__item" to={'/'}>Бронирование</Link></li>
                    <li><Link className="menu__item" to={'/'}>Помощь</Link></li>
                </ul>
            </div>
        </header>
    )
}

export default Nav;