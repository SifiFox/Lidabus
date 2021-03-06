import React from 'react'
import '../scss/InnerMenu.scss'
import ask from '../img/ask.png'
import call from '../img/call.png'
import {Link} from "react-router-dom";



function InnerMenu(props){

    return(
        <div className="menu--right">
            <div className="menu--right--wrap">


                <div className="menu--right--top">
                    <div className="round">
                        <button  className="menu--profile--link"
                                 onClick={props.loginToggle} >
                            вход
                        </button>

                    </div>
                </div>


                <div className="menu--right--down">

                    <div className="menu--right--inner--top">
                        <img src={ ask } alt="" />
                        <Link to={"/"}/>

                    </div>

                    <div className="menu--right--inner--bottom">
                        <img src={call} alt="" />

                    </div>

                </div>


            </div>
        </div>


    )

}

export default InnerMenu