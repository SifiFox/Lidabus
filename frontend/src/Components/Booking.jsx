import React, {useState} from 'react';
import '../scss/booking.scss'
import BookingFindForm from "./BookingFindForm";
import BookingOutput from "./BookingOutput";



function Booking(){


    const [output, setOutput] = useState(true)
    const [outputDate, setOutputDate] = useState(false)

    function updateData(value){
        setOutput(value)
    }

    function updateOutputDate(value){
        setOutputDate(value)
    }



    return(
        <div className="booking--wrapper">

            <div className="info--title">
                <div className="title--line"></div>
                <h2>Бронирование</h2>
                <div className="title--line"></div>
            </div>

            <BookingFindForm
                updateData={updateData}
                updateOutputDate={updateOutputDate}
            />

            {
                output
                    ? <BookingOutput/>
                    : null

            }


        </div>
    )

}

export default Booking