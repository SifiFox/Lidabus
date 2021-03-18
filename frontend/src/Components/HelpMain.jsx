import React from 'react'
import {BrowserRouter as Router, Link} from "react-router-dom";

import Contacts from "./Contacts";
import '../scss/HelpMain.scss'
import Partners from "./Partners";
import Main from "./Main";
import Booking from "./Booking";
import Help from "./Help";
import Drivers from "./Drivers";

const HelpMain = (props) =>{



    return(
        <div className='help--main--wrapper'>

            <div className="help--main--nav--wrapper">
                <div className="help--main--nav">
                    <Link to={"/contacts"} className="help--main--link">
                        <p>контакты</p>
                    </Link>

                    <Link to={'/partners'} className="help--main--link">
                        <p>партнеры</p>
                    </Link>

                    <Link to={'/partners'} className="help--main--link">
                        <p>условия</p>
                    </Link>

                    <Link to={'/partners'} className="help--main--link">
                        <p>водителям</p>
                    </Link>

                    <Link to={'/partners'} className="help--main--link">
                        <p>перевочикам</p>
                    </Link>
                </div>
            </div>


        </div>
    )
}

export default HelpMain