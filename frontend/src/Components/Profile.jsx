import React from 'react'
import "../scss/general.scss"
import "../scss/profile.scss"

import profile from "../img/profile.png"
import ProfileCards from "./ProfileCards";

function Profile(){
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
                            <p>Антонович Дмитрий Анатольевич</p>
                            <p>+375(33)444-55-66</p>
                        </div>

                    </div>

                    <div className="profile--nav--right">
                        <button className="edit">
                            редактировать
                        </button>
                        <button className="primary--button">
                            Выйти
                        </button>
                    </div>
                </div>

                <ProfileCards/>

        </div>
    )
}

export default Profile