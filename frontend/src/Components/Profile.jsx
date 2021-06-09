import React, {useState} from 'react'
import "../scss/general.scss"
import "../scss/profile.scss"

import profile from "../img/profile.png"
import ProfileCards from "./ProfileCards";
import {Route} from "react-router";
import {useHistory} from "react-router-dom";
import AdminPanel from "./AdminPanel";
import UserEditForm from "./UserEditForm";

import $ from "jquery"
import UserShowRoutes from "./UserShowRoutes";
import UserCurrentOrders from "./UserCurrentOrders";
import ProfileDriver from "./ProfileDriver";
import UserRoutesByDate from "./userRoutesByDate";

function Profile(props){

    const history = useHistory();

    function testHistory(){
            localStorage.clear();
            history.push("/");
            window.location.reload();
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

    const [flag, setFlag] = useState(0)
    const [dateFlag, setDateFlag] = useState(0)


    const [routesByDate, setRoutesByDate] = useState()

    function takeRoutes(){
        setFlag(1)
        console.log('takeRoutes')
    }

    function userRoutesByDate(item){
        console.log(item)
        setDateFlag(1)
        setRoutesByDate(item)
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



            {/*{*/}
            {/*localStorage.getItem('Role') == 'User' ?*/}
            {/*<UserCurrentOrders/> : null*/}
            {/*}*/}

            {
                localStorage.getItem('Role') == 'Driver' ?
                    <ProfileDriver/> : null

            }

            {
                localStorage.getItem('Role') == 'ADMIN' ?
                    <AdminPanel/> : null

            }

            {
                localStorage.getItem('Role') == 'User' ?
                    <ProfileCards
                        takeRoutes={takeRoutes}
                        userRoutesByDate={userRoutesByDate}
                    /> : null
            }

            {
                dateFlag == 1
                ? <UserRoutesByDate
                        item={routesByDate}/>
                : null
            }



            {
                    flag == 1 && dateFlag != 1
                        ?
                        <UserShowRoutes/>
                        : null
            }

        </div>
    )
}

export default Profile