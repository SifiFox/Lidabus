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

            <div className="test">

            </div>
        </>
    )
}
export default BookingOutput