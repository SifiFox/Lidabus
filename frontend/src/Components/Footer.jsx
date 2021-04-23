import React from 'react';
import {Link} from "react-router-dom";
import "../scss/footer.scss"


import inst from "../img/inst.png"
import vk from "../img/vk.png"




function Footer() {

    return(

        <div className="footer--wrapper">

            <div className="footer--wrapper--inner">

                <div className="footer--socials--wrapper">

                    <p className="footer--socials--desc">
                        соцсети
                    </p>

                    <ul className="footer--socials">

                        <li className="footer--social">
                            <Link to={'/'}>
                                <img src={ inst } alt=""/>
                            </Link>
                        </li>

                        <li className="footer--social">
                            <Link to={'/'}>
                                <img src={ vk } alt=""/>
                            </Link>
                        </li>

                    </ul>

                </div>



                <ul className="footer--nav">

                    <li className="footer--nav--link">
                        <Link to={'/help'}>помощь</Link>
                    </li>

                    <li className="footer--nav--link">
                        <Link to={'/'}>забронировать</Link>
                    </li>

                    <li className="footer--nav--link">
                        <Link to={'/'}>автопарк</Link>
                    </li>

                    <li className="footer--nav--link">
                        <Link to={'/'}>для водителей</Link>
                    </li>

                </ul>


                <div className="footer--contacts--wrapper">

                    <p className="footer--contacts--desc">
                        контакты
                    </p>

                    <ul className="footer--contacts">

                        <li className="footer--contact">
                            594-10-00
                        </li>

                        <li className="footer--contact">
                            394-10-00
                        </li>

                        <li className="footer--contact">
                            794-10-00
                        </li>

                    </ul>

                </div>
            </div>

            <p className="copyrite">
                &copy;  Лидская стрела
            </p>


        </div>

    )

}


export default Footer