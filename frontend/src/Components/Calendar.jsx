import React from 'react';
import 'react-day-picker/lib/style.css';
import DayPickerInput from "react-day-picker/DayPickerInput";
import "../scss/calendar.scss"
import 'moment/locale/ru'

import MomentLocaleUtils, {
    formatDate,
} from 'react-day-picker/moment';
import moment from "moment";


const today = new Date();



function Calendar(){

    const dayPickerProps = {
        localeUtils: MomentLocaleUtils,
        locale: "ru"
    }

    let tomorrow = new Date();
    tomorrow = dayPickerProps.localeUtils.formatDate(tomorrow.setDate(today.getDate(today)+1));

    return(
        <div>
            <DayPickerInput

                dayPickerProps={dayPickerProps}
                formatDate={formatDate}
                format="LL"
                placeholder={`${formatDate(tomorrow, 'LL', 'ru')}`}
                onDayChange={day => {
                    console.log(dayPickerProps.localeUtils.formatDate(today, 'LL', 'ru'))
                    console.log(dayPickerProps.localeUtils.formatDate(tomorrow, 'LL', 'ru'))

                }}
            />

        </div>
    )
}
export default Calendar