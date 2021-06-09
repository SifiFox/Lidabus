import React, {useState} from 'react'
import {
    CircularProgressbar,
    CircularProgressbarWithChildren,
    buildStyles
} from "react-circular-progressbar";
import "react-circular-progressbar/dist/styles.css";

import "../scss/cards.scss"

import card from '../img/card.svg'
import DayPicker from "react-day-picker";
import MomentLocaleUtils, {formatDate} from "react-day-picker/moment";
import DayPickerInput from "react-day-picker/DayPickerInput";
import {Link, Route, Switch, useHistory} from "react-router-dom";
import {Router} from "react-router";
import RouteOrder from "./RouteOrder";
import UserShowRoutes from "./UserShowRoutes";
import moment from "moment";



const percentage = 4.8;

const today = new Date();
const formate = "YYYY/MM/DD";

function ProfileCards(props){

    const dayPickerProps = {
        localeUtils: MomentLocaleUtils,
        locale: "ru"
    }

    let initDay = dayPickerProps.localeUtils.formatDate(today.setDate(today.getDate(today)))
    initDay = moment(initDay).format(formate);


    const [selectedDay, setSelectedDay] = useState(initDay)

    let item ={
        ID_User: localStorage.getItem("ID"),
        Date: selectedDay
    }

    function handleDayClick(day) {
        day = dayPickerProps.localeUtils.formatDate(day.setDate(day.getDate(day)))
        let testDay = moment(day).format(formate)
        setSelectedDay(testDay)
    }

    function sumbitData(){
        props.userRoutesByDate(item)
        setSelectedDay(initDay)
    }



    return(
        <div className="cards--wrap">

            <div className="card payment">
                <img src={card} alt=""/>
                <p>Mastercard   ******3576</p>

                <h3 className="card--desc">
                    способ оплаты
                </h3>

                <button className="primary--button">
                    изменить
                </button>

            </div>


            <div className="card rating">


                <div label="progressbar Square" className="progressbar" style={{width: 270}}>
                    <CircularProgressbar
                        minValue={0}
                        maxValue={5}
                        value={localStorage.getItem('Rating')}
                        text={`${localStorage.getItem('Rating')}`}
                        styles={buildStyles({
                            strokeLinecap: "butt",
                            pathColor: "#EE1C1C",
                            textColor: "#000"

                        })}/>
                </div>


                <h3 className="card--desc">мой рейтинг</h3>
            </div>


            <div className="card">
                <DayPicker
                    dayPickerProps={dayPickerProps}
                    formatDate={formatDate}
                    format="LL"
                    onDayClick={day => {
                        handleDayClick(day)
                    }}
                    // props.userRoutesByDate(item)
            />
                {
                    selectedDay != initDay
                    ? sumbitData()
                    : console.log('equal')
                    // console.log(selectedDay)
                }
                <h3 className="trips">мои поездки</h3>

                <button className="primary--button"
                    onClick={props.takeRoutes}
                >
                   показать все
                </button>
            </div>

        </div>
    )
}

export default ProfileCards