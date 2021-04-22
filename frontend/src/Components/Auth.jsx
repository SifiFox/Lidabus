import React, {Component} from 'react';
import "../scss/RegAuth.scss"
import cross from '../img/cross.png'
import {Link} from "react-router-dom";
import axios from "axios";


export default class Auth extends Component{



    handleSubmit = e => {
        e.preventDefault();
        const data = {
            email: this.email,
            password: this.password,
        };

        console.log(data)

        axios.post('http://localhost:8000/login', data)
            .then(res => {
                console.log(res)
            })
            .catch(err =>{
                console.log(err)
            })
    }


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
                        Логин
                    </h1>


                    <form onSubmit={this.handleSubmit}>

                        <div className="input--wrapper">
                            <input type="text" className="form--input" placeholder="Email"
                                   onChange={e => this.email = e.target.value}
                            />
                        </div>

                        <div className="input--wrapper">
                            <input type="email" className="form--input" placeholder="Пароль"
                                   onChange={e => this.password = e.target.value}
                            />
                        </div>


                        <button>
                            Войти
                        </button>

                        <Link to={'/'}>
                            Забыли пароль?
                        </Link>

                        <Link to={'/register'}>
                            Регистрация
                        </Link>

                    </form>
                </div>
            </div>

        )
    }

}
