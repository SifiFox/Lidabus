import React from 'react'
import {Link} from "react-router-dom";

import '../scss/HelpMain.scss'

const HelpMain = () =>{



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

                    <Link to={'/conditions'} className="help--main--link">
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