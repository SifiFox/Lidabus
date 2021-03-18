import React from 'react';
import '../scss/booking.scss'
import BookingFindForm from "./BookingFindForm";


function Booking(){
    return(
        <div className="booking--wrapper">

            <div className="info--title">
                <div className="title--line"></div>
                <h2>Бронирование</h2>
                <div className="title--line"></div>
            </div>

            <BookingFindForm/>

        </div>
    )

}

export default Booking