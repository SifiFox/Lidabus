import React from 'react'
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



const percentage = 4.8;

const today = new Date();


function ProfileCards(){



    const dayPickerProps = {
        localeUtils: MomentLocaleUtils,
        locale: "ru"
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
                    placeholder={`${formatDate(today, 'LL', 'ru')}`}
                    onDayChange={day => {
                        console.log(dayPickerProps.localeUtils.formatDate(today, 'LL', 'ru'))
                    }}
                />

                <h3 className="trips">мои поездки</h3>

                <button className="primary--button">
                    показать все
                </button>
            </div>

        </div>
    )
}

export default ProfileCards