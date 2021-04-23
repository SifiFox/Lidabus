import React from 'react';
import '../scss/help.scss'
import '../scss/general.scss'
import HelpMain from "./HelpMain";
import {BrowserRouter as Router, Route, Switch} from "react-router-dom";
import Contacts from "./Contacts";
import Partners from "./Partners";


    const Help = (props) => {
    return(
        <div className="help--wrapper">

            <div className="info--title">
            <div className="title--line"></div>
            <h2>Помощь</h2>
                <div className="title--line"></div>
            </div>


            <div className="help--main--description">
               <p className="sub--border">Реквизиты в Республике Беларусь:  </p>
                 <p className="sub--border">  ООО "Онлайн Маршрутки" </p>
                <p className="sub--border">  Свидетельство о государственной регистрации выдано Минским горисполкомом от 24.08.2018. </p>
                    <p>  УНП 193125500 </p>
                        <p>  РБ, 220073, г. Минск, ул. Ольшевского, д.24, оф. 403 п.16-49</p>
            </div>

            <Router>
                <HelpMain/>
                    <div className="help-inner">
                        <Switch>
                            <Route component={Contacts} path={'/contacts'}/>
                            <Route component={Partners} path={'/partners'}/>
                        </Switch>
                    </div>
            </Router>


            {props.children}

        </div>
    )

}

export default Help