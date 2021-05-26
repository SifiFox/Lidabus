import React from 'react';
import '../scss/booking.scss'
import BookingFindForm from "./BookingFindForm";
import BookingOutput from "./BookingOutput";


function Booking(){


    let item = {
        User_ID: 123,
        Route_ID: 123,
        ID_PassengerSeat: [1,2,3]
    }


    return(
        <div className="booking--wrapper">

            <div className="info--title">
                <div className="title--line"></div>
                <h2>Бронирование</h2>
                <div className="title--line"></div>
            </div>

            <BookingFindForm/>

            <BookingOutput
             />
        </div>
    )

}

export default Booking