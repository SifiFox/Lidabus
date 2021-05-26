import React from 'react'
import '../scss/findForm.scss'
import Calendar from "./Calendar";

function BookingFindForm(){





    return(
        <div className="booking--find--wrapper">
            <div className="booking--form--container">
                <form action="" method="GET" className="booking--find">
                    <div className="form--mod">
                        <p>откуда</p>
                        <select name="" id="">
                            <option selected='selected' value="Минск">Минск</option>
                        </select>
                        <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.3536 4.35355C19.5488 4.15829 19.5488 3.84171 19.3536 3.64645L16.1716 0.464466C15.9763 0.269204 15.6597 0.269204 15.4645 0.464466C15.2692 0.659728 15.2692 0.976311 15.4645 1.17157L18.2929 4L15.4645 6.82843C15.2692 7.02369 15.2692 7.34027 15.4645 7.53553C15.6597 7.7308 15.9763 7.7308 16.1716 7.53553L19.3536 4.35355ZM1 4.5H19V3.5H1V4.5Z" fill="#EE1C1C"/>
                            <path d="M0.646446 14.3536C0.451185 14.1583 0.451185 13.8417 0.646446 13.6464L3.82843 10.4645C4.02369 10.2692 4.34027 10.2692 4.53553 10.4645C4.7308 10.6597 4.7308 10.9763 4.53553 11.1716L1.70711 14L4.53553 16.8284C4.7308 17.0237 4.7308 17.3403 4.53553 17.5355C4.34027 17.7308 4.02369 17.7308 3.82843 17.5355L0.646446 14.3536ZM19 14.5H1V13.5H19V14.5Z" fill="#EE1C1C"/>
                        </svg>

                    </div>
                    <div className="form--mod">
                        <p>куда</p>
                        <select >
                            <option selected="selected" value="Лида">Лида</option>
                        </select>
                    </div>
                    <div className="form--mod">
                        <p>дата</p>
                        <Calendar/>
                    </div>
                    <div className="form--mod">
                        <p>пассажиры</p>
                        <select>
                            <option value="">1 пассажир</option>
                            <option value="">2 пассажира</option>
                            <option value="">3 пассажира</option>
                            <option value="">4 пассажира</option>
                            <option value="">5 пассажиров</option>
                        </select>
                    </div>
                    <button className="form--submit" type="submit"

                    >
                        <p>Найти</p>
                    </button>
                </form>
            </div>

            <div className="days--choice">
                <p>Завтра</p>
                <p>Послезавтра</p>
            </div>




        </div>
    )
}

export default BookingFindForm