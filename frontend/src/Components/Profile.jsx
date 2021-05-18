import React, {useState} from 'react'
import "../scss/general.scss"
import "../scss/profile.scss"

import profile from "../img/profile.png"
import ProfileCards from "./ProfileCards";
import {Route} from "react-router";
import {useHistory} from "react-router-dom";
import AdminPanel from "./AdminPanel";
import UserEditForm from "./UserEditForm";



function Profile(props){

    const history = useHistory();

    function testHistory(){
            history.push("/");
            localStorage.clear();
    }


    const [visible, setVisible] = useState({
        isShowed: false
    });

    function handleShowClick(){
        setVisible({isShowed: true})
        console.log(visible.isShowed + " showed")
    }

    function handleHideClick(){
        setVisible({isShowed: false})
        console.log(visible.isShowed + " hided")
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
                        {
                            visible.isShowed ?
                              <>
                                <button className= "edit"
                                onClick={handleHideClick}>
                                    редактировать
                                </button>
                              </>
                                :
                                <button className= "edit"
                                onClick={handleShowClick}
                                >
                                    редактировать
                                </button>
                        }

                        {/*/!*<button className={`edit ${visible == true ? 'edit--closed' : 'edit--opened'}`}*!/*/}

                        {/*<button className= "edit"*/}
                        {/*        onClick={console.log(visible.isShowed)}>*/}
                        {/*    редактировать*/}
                        {/*</button>*/}
                        {/*{*/}
                        {/*  console.log(visible.isShowed)*/}
                        {/*    // !visible.isShowed ? handleShowClick() : handleHideClick()*/}
                        {/*}*/}



                        <button className="primary--button"
                            onClick={testHistory}>

                            Выйти
                        </button>

                    </div>
                </div>

            {
                visible.isShowed ?
                    <UserEditForm />
                    : null
            }



            <ProfileCards/>
               {localStorage.getItem('Role') == 'ADMIN' ?
                   <AdminPanel/> : <br/>
               }
        </div>
    )
}

export default Profile