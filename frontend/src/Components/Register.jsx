import React, {Component} from 'react';
import "../scss/RegAuth.scss"
import cross from '../img/cross.png'
import {Link} from "react-router-dom";



export default class Register extends Component{

        // handleSubmit = e =>{
        //     e.preventDefault();
        //     const data = {
        //         Name: this.Name,
        //         Email: this.Email,
        //         password: this.password,
        //         confirmPassword: this.confirmPassword
        //     };
        //     console.log(data);
        // };

        render(){
            return(


                <div className="RegAuth--wrap">
                    <div className="exit">

                        <a href={'/'}>
                            <img className="exit--pic" src={ cross } alt=""/>
                        </a>
                    </div>
                    <div className="RegAuth--outline">
                    </div>
                    <div className="RegAuth--inner">
                        <h1 className="title">
                            Регистрация
                        </h1>

                        <form onSubmit={this.handleSubmit}>

                            <div className="input--wrapper">
                                <input type="text" className="form--input" placeholder="Ваше имя"
                                    onChange={e => this.Name = e.target.value}
                                />
                            </div>

                            <div className="input--wrapper">
                                <input type="email" className="form--input" placeholder="email"
                                       onChange={e => this.Email = e.target.value}
                                />
                            </div>

                            <div className="input--wrapper">
                                <input type="password" className="form--input" placeholder="Пароль"
                                       onChange={e => this.password = e.target.value}
                                />
                            </div>

                            <div className="input--wrapper">
                                <input type="password" className="form--input" placeholder="Подтвердить пароль"
                                       onChange={e => this.confirmPassword = e.target.value}
                                />
                            </div>

                            <button>
                                Зарегистрироваться
                            </button>

                            <Link >
                                У меня уже есть аккаунт
                            </Link>
                        </form>
                    </div>
                </div>
            )
        }
}

