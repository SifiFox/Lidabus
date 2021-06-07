import React, {useState} from 'react';
import 'react-day-picker/lib/style.css';
import DayPickerInput from "react-day-picker/DayPickerInput";
import "../scss/calendar.scss"
import 'moment/locale/ru'
import moment from "moment";

import MomentLocaleUtils, {
    formatDate
} from 'react-day-picker/moment';
import {now} from "date-fns/esm/format";

const today = new Date();
const formate = "YYYY/MM/DD"


function Calendar(props){

    const dayPickerProps = {
        localeUtils: MomentLocaleUtils,
        locale: "ru"
    }


    let tomorrow = new Date();
    tomorrow = dayPickerProps.localeUtils.formatDate(tomorrow.setDate(today.getDate(today)));
    const [selectedDay, setSelectedDay] = useState(today)

    function handleDayClick(day){
        let dateTest = moment(day).format(formate)
        // console.log(dateTest)
        setSelectedDay(day)
        props.handleDayClick(day)
    }
    return(
        <div>
            <DayPickerInput
                dayPickerProps={dayPickerProps}
                formatDate={formatDate}
                format="LL"
                placeholder={`${formatDate(tomorrow, 'LL', 'ru')}`}
                onDayChange={day => {
                    handleDayClick(day)
                }}

            />
        </div>
    )
}
export default Calendar