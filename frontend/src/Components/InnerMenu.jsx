import React from 'react'
import '../scss/InnerMenu.scss'
import ask from '../img/ask.png'
import call from '../img/call.png'
import {Link} from "react-router-dom";
import  { useState } from 'react'


function InnerMenu(props){


    const [visible, setVisible] = useState({
            visible: ''
    })



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


                <div className={`menu--right--down ${visible ? 'opened' : 'closed'}`}
                onClick={()=>{
                    setVisible(!visible)
                }}
                >

                    <div className="menu--right--inner--top">

                        <Link to={"/help"}>
                            <img src={ ask } alt="" />
                            <p>помощь</p>
                        </Link>

                    </div>

                    <div className="menu--right--inner--bottom">

                        <Link to={"/"}>
                            <img src={call} alt="" />
                            <p>звонок</p>
                        </Link>
                    </div>

                </div>


            </div>
        </div>


    )

}
export default InnerMenu