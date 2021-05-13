import React from 'react'
import "../scss/general.scss"
import "../scss/profile.scss"

import profile from "../img/profile.png"
import ProfileCards from "./ProfileCards";
import {Route} from "react-router";
import {useHistory} from "react-router-dom";



function Profile(){

    const history = useHistory();

    function testHistory(){
            history.push("/");
            localStorage.clear();
    }



    return(
        <div className="profile--wrapper">
            <div className="info--title">
                <div className="title--line"></div>
                <h2>Личный кабинет</h2>
                <div className="title--line"></div>
            </div>

                <div className="profile--nav">
                    <div className="profile--nav--left">
                        <div className="round">
                                <img src={profile} alt=""/>
                        </div>

                        <div className="profile--nav--left--desc">
                            <p>{localStorage.getItem('Surname')} {localStorage.getItem('Name')} {localStorage.getItem('Patronymic')}</p>
                            <p>{localStorage.getItem('PhoneNumber')}</p>
                        </div>

                    </div>

                    <div className="profile--nav--right">
                        <button className="edit">
                            редактировать
                        </button>
                        <button className="primary--button"
                            onClick={testHistory}>

                            Выйти
                        </button>
                    </div>
                </div>

                <ProfileCards/>

        </div>
    )
}

export default Profile