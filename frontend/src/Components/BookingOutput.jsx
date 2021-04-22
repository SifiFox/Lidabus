import React from 'react'
import '../scss/general.scss'
import '../scss/booking.scss'

import 'react-day-picker/lib/style.css';
import "../scss/calendar.scss"
import 'moment/locale/ru'
import MomentLocaleUtils, {formatDate} from "react-day-picker/moment";
import DayPickerInput from "react-day-picker/DayPickerInput";
import moment from "moment";


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



    return(
        <div className="output--header">
            <div className="output--date"
                 dayPickerProps={dayPickerProps}
                 formatDate={formatDate}
                 format="LL"

                 placeholder={`${formatDate(today, 'LL', 'ru')}`}>
                {dayPickerProps.localeUtils.formatDate(today, 'DD', 'ru')}
            </div>

            {moment().format("MMMM", 'ru')}
            <h2 className="info--title">Ближайшие</h2>


            <div className="test">

            </div>
        </div>
    )
}
export default BookingOutput