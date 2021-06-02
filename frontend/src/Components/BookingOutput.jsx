import React, {useState} from 'react'
import '../scss/general.scss'
import '../scss/booking.scss'

import 'react-day-picker/lib/style.css';
import "../scss/calendar.scss"
import 'moment/locale/ru'
import MomentLocaleUtils, {formatDate} from "react-day-picker/moment";
import DayPickerInput from "react-day-picker/DayPickerInput";
import moment from "moment";
import {BrowserRouter as Router, Link, Route, Switch} from "react-router-dom";
import User from "./User";
import TopRoutes from "./TopRoutes";


const data ={};
data[{}] = {
    '01' : "Января",
    '02' : "Февраля",
    '03' : "Марта",
     '4': 'test',
    '04': 'test'
};

const today = new Date();

        function BookingOutput(){
            const dayPickerProps = {
                localeUtils: MomentLocaleUtils,
                locale: "ru"
            }



    const [error, setError] = useState(null);
    const [isLoaded, setIsLoaded] = useState(false);
    const [items, setItems] = useState([]);


    return(
        <>
        <div className="output--header">
            <div className="date">
                <div className="output--date--day"
                     dayPickerProps={dayPickerProps}
                     formatDate={formatDate}
                     format="LL"

                     placeholder={`${formatDate(today, 'LL', 'ru')}`}>
                    {dayPickerProps.localeUtils.formatDate(today, 'DD', 'ru')}
                </div>
                <div className="output--date--month">
                    {moment().format("MMMM", 'ru')}
                </div>
            </div>


            <h2 className="info--title subTitle">Ближайшие</h2>
        </div>


            <TopRoutes
                    Destination={'Лида'}
            />

            <TopRoutes
                Destination={'Минск'}
            />

        </>
    )
}
export default BookingOutput